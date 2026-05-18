<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CompanyDashboardController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display the company dashboard.
     */
    public function index()
    {
        $user    = Auth::user();
        $company = $user->companies()->first();

        if ($company) {
            return redirect()->route('company.show', $company);
        }

        // Edge case: admin sem empresa ainda (deve criar uma)
        return view('company.dashboard', [
            'companies'          => collect(),
            'totalEmployees'     => 0,
            'totalBusinessCards' => 0,
            'totalViews'         => 0,
            'subscription'       => null,
            'currentSeats'       => 0,
            'usedSeats'          => 0,
        ]);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create(): View
    {
        return view('company.create');
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|in:startup,small,medium,large,enterprise',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $companyData = $request->except(['logo']);
        $companyData['slug'] = Str::slug($request->name);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $companyData['logo'] = $logoPath;
        }

        $company = Company::create($companyData);
        
        // Associate the creating user as admin
        $company->users()->attach(Auth::id(), [
            'role' => 'admin',
            'is_admin' => true,
        ]);

        return redirect()->route('company.dashboard')->with('success', 'Empresa criada com sucesso!');
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        $user          = Auth::user();
        $businessCards = $company->businessCards()->with('user')->latest()->get();
        $employees     = $company->users()->withPivot(['role', 'is_admin'])->get();
        $subscription  = $user->subscription('default');
        $currentSeats  = $subscription ? ($subscription->quantity ?? 0) : 0;
        $usedSeats     = $employees->count();

        return view('company.show', compact(
            'company', 'businessCards', 'employees',
            'subscription', 'currentSeats', 'usedSeats'
        ));
    }

    public function downloadTemplate(Company $company)
    {
        $this->authorize('update', $company);

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="cardify_template.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = [
            'nome_completo', 'email', 'cargo', 'departamento',
            'telefone', 'telemovel', 'website', 'bio',
            'linkedin', 'twitter', 'instagram', 'facebook', 'github',
        ];

        $example = [
            'Ana Silva', 'ana.silva@empresa.com', 'Diretora de Marketing', 'Marketing',
            '+351 21 000 0000', '+351 912 000 000', 'https://empresa.com',
            'Apaixonada por estratégia digital e crescimento de marca.',
            'https://linkedin.com/in/anasilva', '', '', '', '',
        ];

        $callback = function () use ($columns, $example) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel
            fputcsv($handle, $columns);
            fputcsv($handle, $example);
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCards(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file  = $request->file('csv_file');
        $path  = $file->getRealPath();
        $data  = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        // Normalise header keys
        $header = array_map(fn($h) => mb_strtolower(trim(preg_replace('/\s+/', '_', $h))), $header);

        $map = [
            'nome_completo' => 'full_name',
            'email'         => 'email',
            'cargo'         => 'position',
            'departamento'  => 'department',
            'telefone'      => 'phone',
            'telemovel'     => 'mobile',
            'website'       => 'website',
            'bio'           => 'bio',
            'linkedin'      => 'linkedin_url',
            'twitter'       => 'twitter_url',
            'instagram'     => 'instagram_url',
            'facebook'      => 'facebook_url',
            'github'        => 'github_url',
        ];

        $created = 0;
        $skipped = 0;

        foreach ($data as $row) {
            if (count($row) !== count($header)) { $skipped++; continue; }
            $row = array_combine($header, $row);

            $fullName = trim($row['nome_completo'] ?? '');
            if (!$fullName) { $skipped++; continue; }

            $cardData = ['company_id' => $company->id, 'user_id' => Auth::id(), 'is_active' => true, 'is_public' => true, 'theme' => 'default'];
            foreach ($map as $csvKey => $field) {
                $val = trim($row[$csvKey] ?? '');
                if ($val !== '') $cardData[$field] = $val;
            }

            // Unique slug from full name
            $base = \Illuminate\Support\Str::slug($fullName);
            $slug = $base;
            $i    = 1;
            while (\App\Models\BusinessCard::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $cardData['slug']  = $slug;
            $cardData['title'] = $fullName; // card title = person name

            \App\Models\BusinessCard::create($cardData);
            $created++;
        }

        return back()->with('import_success', "Importação concluída: {$created} cartões criados" . ($skipped ? ", {$skipped} linhas ignoradas." : '.'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(Company $company): View
    {
        $this->authorize('update', $company);
        
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'industry' => 'nullable|string|max:255',
            'size' => 'nullable|in:startup,small,medium,large,enterprise',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $companyData = $request->except(['logo']);
        
        if ($request->name !== $company->name) {
            $companyData['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $companyData['logo'] = $logoPath;
        }

        $company->update($companyData);

        return redirect()->back()->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Manage company employees.
     */
    public function employees(Company $company): View
    {
        $this->authorize('update', $company);
        
        $employees = $company->users()->withPivot(['role', 'is_admin'])->get();
        
        return view('company.employees', compact('company', 'employees'));
    }
}
