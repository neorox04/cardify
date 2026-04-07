<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessCard;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BusinessCardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $businessCards = Auth::user()->businessCards()->with('company')->latest()->get();
        
        return view('business-cards.index', compact('businessCards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Auth::user()->companies;
        
        return view('business-cards.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'bio' => 'nullable|string|max:500',
            'company_id' => 'nullable|exists:companies,id',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'theme' => 'string|in:default,modern,classic,elegant',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $businessCardData = $request->except(['avatar', 'cover_image']);
        $businessCardData['user_id'] = Auth::id();
        
        // Generate unique slug
        $baseSlug = Str::slug($request->full_name);
        $slug = $baseSlug;
        $count = 1;
        while (BusinessCard::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }
        $businessCardData['slug'] = $slug;

        if ($request->hasFile('avatar')) {
            $businessCardData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $businessCardData['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $businessCard = BusinessCard::create($businessCardData);

        return redirect()->route('business-cards.show', $businessCard)->with('success', 'Cartão de visita criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessCard $businessCard): View
    {
        $businessCard->incrementViews();
        
        return view('business-cards.show', compact('businessCard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessCard $businessCard): View
    {
        $this->authorize('update', $businessCard);
        
        $companies = Auth::user()->companies;
        
        return view('business-cards.edit', compact('businessCard', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessCard $businessCard)
    {
        $this->authorize('update', $businessCard);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'website' => 'nullable|url',
            'bio' => 'nullable|string|max:500',
            'company_id' => 'nullable|exists:companies,id',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'theme' => 'string|in:default,modern,classic,elegant',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $businessCardData = $request->except(['avatar', 'cover_image']);

        if ($request->hasFile('avatar')) {
            $businessCardData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $businessCardData['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $businessCard->update($businessCardData);

        return redirect()->back()->with('success', 'Cartão de visita atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessCard $businessCard)
    {
        $this->authorize('delete', $businessCard);

        $businessCard->delete();

        return redirect()->route('business-cards.index')->with('success', 'Cartão de visita excluído com sucesso!');
    }

    /**
     * Display public business card.
     */
    public function publicCard(string $slug): View
    {
        $businessCard = BusinessCard::where('slug', $slug)
            ->where('is_public', true)
            ->where('is_active', true)
            ->with('company')
            ->firstOrFail();

        $businessCard->incrementViews();

        return view('business-cards.public', compact('businessCard'));
    }

    /**
     * Show save contact page (for QR code scanning).
     */
    public function saveContact(BusinessCard $businessCard)
    {
        $businessCard->increment('qr_scans');
        return view('business-cards.save-contact', compact('businessCard'));
    }

    /**
     * Download vCard for business card.
     */
    public function downloadVCard(BusinessCard $businessCard)
    {
        $businessCard->increment('contacts_saved');
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$businessCard->full_name}\r\n";
        // Split name properly
        $nameParts = explode(' ', $businessCard->full_name);
        $firstName = $nameParts[0] ?? '';
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';
        $vcard .= "N:{$lastName};{$firstName};;;\r\n";
        if ($businessCard->position) {
            $vcard .= "TITLE:{$businessCard->position}\r\n";
        }
        if ($businessCard->company) {
            $vcard .= "ORG:{$businessCard->company->name}\r\n";
        }
        if ($businessCard->email) {
            $vcard .= "EMAIL;TYPE=WORK:{$businessCard->email}\r\n";
        }
        if ($businessCard->phone) {
            $vcard .= "TEL;TYPE=WORK:{$businessCard->phone}\r\n";
        }
        if ($businessCard->mobile) {
            $vcard .= "TEL;TYPE=CELL:{$businessCard->mobile}\r\n";
        }
        if ($businessCard->website) {
            $vcard .= "URL:{$businessCard->website}\r\n";
        }
        if ($businessCard->linkedin_url) {
            $vcard .= "X-SOCIALPROFILE;TYPE=linkedin:{$businessCard->linkedin_url}\r\n";
        }
        
        // Add photo as base64
        if ($businessCard->avatar && Storage::disk('public')->exists($businessCard->avatar)) {
            $photoPath = Storage::disk('public')->path($businessCard->avatar);
            $photoData = file_get_contents($photoPath);
            $base64Photo = base64_encode($photoData);
            $mimeType = mime_content_type($photoPath);
            
            // Determine photo type
            $photoType = 'JPEG';
            if (str_contains($mimeType, 'png')) {
                $photoType = 'PNG';
            } elseif (str_contains($mimeType, 'gif')) {
                $photoType = 'GIF';
            }
            
            $vcard .= "PHOTO;ENCODING=b;TYPE={$photoType}:{$base64Photo}\r\n";
        }
        
        $vcard .= "END:VCARD\r\n";

        $filename = Str::slug($businessCard->full_name) . '.vcf';

        return response($vcard)
            ->header('Content-Type', 'text/vcard')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
