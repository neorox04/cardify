<?php

namespace App\Http\Controllers;

use App\Mail\SharedContactEmail;
use App\Models\BusinessCard;
use App\Models\SharedContact;
use App\Support\VCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContactShareController extends Controller
{
    /**
     * A visitor shares their contact back with the card owner.
     */
    public function store(Request $request, BusinessCard $businessCard)
    {
        // Only live cards (owner subscribed) accept share-backs.
        if (!$businessCard->ownerHasActiveSubscription()) {
            abort(404);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:40',
            'email'     => 'required|email|max:255',
            'method'    => 'required|in:email,qr',
        ]);

        $shared = SharedContact::create([
            'business_card_id'  => $businessCard->id,
            'recipient_user_id' => $businessCard->user_id,
            'token'             => Str::random(40),
            'full_name'         => $validated['full_name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'],
            'method'            => $validated['method'],
            'expires_at'        => $validated['method'] === 'qr' ? now()->addMinutes(5) : null,
        ]);

        if ($validated['method'] === 'email') {
            if ($businessCard->email) {
                Mail::to($businessCard->email)->send(new SharedContactEmail($shared, $businessCard));
            }

            return redirect()
                ->route('card.save', $businessCard)
                ->with('shared_ok', 'email');
        }

        // Live QR — the owner scans it to grab the contact instantly.
        return redirect()->route('contact.qr', $shared->token);
    }

    /**
     * Show the live QR for the visitor to display (owner scans it).
     */
    public function qr(string $token): View
    {
        $shared = SharedContact::where('token', $token)->firstOrFail();

        return view('contacts.share-qr', compact('shared'));
    }

    /**
     * Serve the shared contact's vCard (hit when the owner scans the QR).
     */
    public function vcard(string $token)
    {
        $shared = SharedContact::where('token', $token)->firstOrFail();

        if ($shared->isExpired()) {
            return response()->view('contacts.share-expired', compact('shared'), 410);
        }

        $vcard = VCard::build([
            'full_name' => $shared->full_name,
            'email'     => $shared->email,
            'phone'     => $shared->phone,
        ]);

        return response($vcard, 200, [
            'Content-Type'        => 'text/vcard; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . Str::slug($shared->full_name) . '.vcf"',
        ]);
    }
}
