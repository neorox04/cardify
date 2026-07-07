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
    public function create(): View|\Illuminate\Http\RedirectResponse
    {
        if (!Auth::user()->subscribed('default')) {
            return redirect()->route('subscriptions.plans');
        }

        $companies = Auth::user()->companies;

        return view('business-cards.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Whether the card name must be forced to the account holder's name.
     *
     * Personal cards (no company) are always locked so a single paid account
     * can't be used to make cards for other people. Company cards are only
     * unlocked when the acting user is an admin of that company (they pay per
     * seat, so distinct employee names are legitimate).
     */
    private function cardNameIsLocked(?int $companyId, \App\Models\User $user): bool
    {
        if (!$companyId) {
            return true;
        }

        $isCompanyAdmin = $user->companies()
            ->where('company_id', $companyId)
            ->wherePivot('is_admin', true)
            ->exists();

        return !$isCompanyAdmin;
    }

    public function store(Request $request)
    {
        // Mirror the create() gate on the write path — the GET form redirect
        // is cosmetic on its own; a direct POST must also require a plan.
        if (!Auth::user()->subscribed('default')) {
            return redirect()->route('subscriptions.plans');
        }

        $request->validate([
            'full_name' => 'nullable|string|max:255',
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

        // Personal cards are always the account holder's name — this prevents
        // one paid account from producing cards for other people. Only company
        // admins (paying per seat) may set a different name.
        $companyId = $request->input('company_id') ? (int) $request->input('company_id') : null;
        $isCompanyCard = $companyId && !$this->cardNameIsLocked($companyId, Auth::user());

        if ($isCompanyCard) {
            // Each company card consumes a paid seat.
            $company = \App\Models\Company::find($companyId);
            if ($company && $company->availableSeats() < 1) {
                return back()->withInput()->with('error',
                    "Atingiste o limite de {$company->seatLimit()} seats. Faz upgrade do plano para adicionares mais cartões.");
            }
            $businessCardData['full_name'] = $request->input('full_name') ?: Auth::user()->name;
        } else {
            $businessCardData['full_name'] = Auth::user()->name;
        }

        // Generate unique slug
        $baseSlug = Str::slug($businessCardData['full_name']);
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
        $nameLocked = $this->cardNameIsLocked($businessCard->company_id, Auth::user());

        return view('business-cards.edit', compact('businessCard', 'companies', 'nameLocked'));
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

        // Lock the name on personal cards: editing must not become a way to
        // rename a card to another person. Company admins keep name control.
        $effectiveCompanyId = $request->filled('company_id')
            ? (int) $request->input('company_id')
            : $businessCard->company_id;
        if ($this->cardNameIsLocked($effectiveCompanyId, Auth::user())) {
            $businessCardData['full_name'] = $businessCard->user->name;
        }

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
    public function publicCard(string $slug): View|\Illuminate\Http\Response
    {
        $businessCard = BusinessCard::where('slug', $slug)
            ->where('is_public', true)
            ->where('is_active', true)
            ->with('company')
            ->firstOrFail();

        // The card only stays public while the owner keeps an active
        // subscription. Once it lapses, the card goes dark.
        if (!$businessCard->ownerHasActiveSubscription()) {
            return response()->view('business-cards.unavailable', compact('businessCard'), 404);
        }

        $businessCard->incrementViews();

        return view('business-cards.public', compact('businessCard'));
    }

    /**
     * Display demo business card with Cardifys info.
     */
    public function demoCard(): View
    {
        $businessCard = new BusinessCard([
            'full_name' => 'Cardifys',
            'position' => 'Cartão de Visita Digital',
            'email' => 'hello@cardifys.com',
            'phone' => '+351 912 345 678',
            'mobile' => '+351 912 345 678',
            'website' => 'https://cardifys.com',
            'bio' => 'A forma mais inteligente de partilhar o teu contacto profissional. Cria o teu cartão digital, partilha com um QR Code e deixa uma impressão memorável. 🚀',
            'linkedin_url' => 'https://linkedin.com/company/cardifys',
            'instagram_url' => 'https://instagram.com/cardifys',
            'twitter_url' => 'https://x.com/cardifys',
            'theme' => 'default',
            'is_public' => true,
            'is_active' => true,
            'views_count' => 1250,
            'slug' => 'demo',
        ]);

        // Set fake metrics for display
        $businessCard->qr_scans = 438;
        $businessCard->contacts_saved = 312;

        // Set an ID for vcard route (won't actually work but prevents errors)
        $businessCard->id = 0;

        return view('business-cards.public', [
            'businessCard' => $businessCard,
            'isDemo' => true,
        ]);
    }

    /**
     * Show save contact page (for QR code scanning).
     */
    public function saveContact(BusinessCard $businessCard)
    {
        if (!$businessCard->ownerHasActiveSubscription()) {
            return response()->view('business-cards.unavailable', compact('businessCard'), 404);
        }

        $businessCard->increment('qr_scans');
        return view('business-cards.save-contact', compact('businessCard'));
    }

    /**
     * Download demo vCard for Cardifys.
     */
    public function demoVCard()
    {
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:Cardifys\r\n";
        $vcard .= "N:;Cardifys;;;\r\n";
        $vcard .= "TITLE:Cartão de Visita Digital\r\n";
        $vcard .= "ORG:Cardifys\r\n";
        $vcard .= "EMAIL;TYPE=WORK:hello@cardifys.com\r\n";
        $vcard .= "TEL;TYPE=WORK:+351 912 345 678\r\n";
        $vcard .= "TEL;TYPE=CELL:+351 912 345 678\r\n";
        $vcard .= "URL:https://cardifys.com\r\n";
        $vcard .= "X-SOCIALPROFILE;TYPE=linkedin:https://linkedin.com/company/cardifys\r\n";
        $vcard .= "X-SOCIALPROFILE;TYPE=instagram:https://instagram.com/cardifys\r\n";
        $vcard .= "X-SOCIALPROFILE;TYPE=twitter:https://x.com/cardifys\r\n";
        $vcard .= "NOTE:A forma mais inteligente de partilhar o teu contacto profissional.\r\n";
        $vcard .= "END:VCARD\r\n";

        return response($vcard)
            ->header('Content-Type', 'text/vcard')
            ->header('Content-Disposition', 'attachment; filename="cardifys-demo.vcf"');
    }

    /**
     * Download vCard for business card.
     */
    public function downloadVCard(BusinessCard $businessCard)
    {
        if (!$businessCard->ownerHasActiveSubscription()) {
            return response()->view('business-cards.unavailable', compact('businessCard'), 404);
        }

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
