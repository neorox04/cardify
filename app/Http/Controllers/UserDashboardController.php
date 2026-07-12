<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessCard;
use App\Models\CardEvent;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserDashboardController extends Controller
{


    /**
     * Display the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $businessCards = $user->businessCards()->latest()->get();
        $totalViews = $businessCards->sum('views_count');

        return view('dashboards.user', compact('user', 'businessCards', 'totalViews'));
    }

    /**
     * Personal analytics — how the user's cards are performing.
     */
    public function analytics(): View
    {
        $user    = Auth::user();
        $cards   = $user->businessCards()->get();
        $cardIds = $cards->pluck('id');

        // ── KPIs (all-time, from cumulative counters) ──────────────────────
        $activeCards = $cards->where('is_active', true)->count();
        $totalViews  = (int) $cards->sum('views_count');
        $totalScans  = (int) $cards->sum('qr_scans');
        $totalSaves  = (int) $cards->sum('contacts_saved');
        $conversion  = $totalScans > 0 ? round(($totalSaves / $totalScans) * 100, 1) : 0;

        // ── Scan activity — last 30 days (from events) ─────────────────────
        $now   = Carbon::now();
        $start = $now->copy()->subDays(29)->startOfDay();

        $dailyRaw = $cardIds->isEmpty() ? collect() : CardEvent::whereIn('business_card_id', $cardIds)
            ->where('type', 'scan')
            ->where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');

        $days = [];
        $daily = [];
        for ($i = 29; $i >= 0; $i--) {
            $day     = $now->copy()->subDays($i);
            $days[]  = $day->format('d/m');
            $daily[] = (int) ($dailyRaw[$day->format('Y-m-d')] ?? 0);
        }
        $scans30 = array_sum($daily);

        // ── Channel breakdown — last 30 days (from events) ─────────────────
        $channels = ['qr' => 0, 'nfc' => 0, 'link' => 0];
        if ($cardIds->isNotEmpty()) {
            $rows = CardEvent::whereIn('business_card_id', $cardIds)
                ->where('type', 'scan')
                ->where('created_at', '>=', $start)
                ->selectRaw('channel, COUNT(*) as c')
                ->groupBy('channel')
                ->get();
            foreach ($rows as $row) {
                $ch = in_array($row->channel, ['qr', 'nfc', 'link'], true) ? $row->channel : 'link';
                $channels[$ch] += (int) $row->c;
            }
        }

        // ── Per-card breakdown ─────────────────────────────────────────────
        $cardStats = $cards->map(fn ($c) => (object) [
            'name'   => $c->full_name,
            'slug'   => $c->slug,
            'active' => (bool) $c->is_active,
            'views'  => (int) $c->views_count,
            'scans'  => (int) $c->qr_scans,
            'saves'  => (int) $c->contacts_saved,
            'conv'   => $c->qr_scans > 0 ? round(($c->contacts_saved / $c->qr_scans) * 100) : 0,
        ])->sortByDesc('views')->values();

        return view('user.analytics', compact(
            'activeCards', 'totalViews', 'totalScans', 'totalSaves', 'conversion',
            'days', 'daily', 'scans30', 'channels', 'cardStats'
        ));
    }

    /**
     * Contacts that visitors shared back with the user.
     */
    public function receivedContacts(): View
    {
        $contacts = Auth::user()->receivedContacts()
            ->with('businessCard:id,full_name,slug')
            ->latest()
            ->paginate(30);

        return view('user.received-contacts', compact('contacts'));
    }

    /**
     * Download a received contact's vCard (recipient only, never expires).
     */
    public function downloadReceived(\App\Models\SharedContact $sharedContact)
    {
        abort_unless($sharedContact->recipient_user_id === Auth::id(), 403);

        $vcard = \App\Support\VCard::build([
            'full_name' => $sharedContact->full_name,
            'email'     => $sharedContact->email,
            'phone'     => $sharedContact->phone,
        ]);

        return response($vcard, 200, [
            'Content-Type'        => 'text/vcard; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . \Illuminate\Support\Str::slug($sharedContact->full_name) . '.vcf"',
        ]);
    }

    /**
     * Export every received contact as a CSV ready to import into any CRM
     * (HubSpot, Pipedrive, Salesforce, Zoho, Notion, Google Contacts…).
     * Standard column headers keep the CRM's import mapping automatic.
     */
    public function exportReceivedContacts(): StreamedResponse
    {
        $user     = Auth::user();
        $filename = 'cardifys-contactos-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($user) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM so Excel opens accented names correctly.
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['first_name', 'last_name', 'email', 'phone', 'source', 'channel', 'captured_at']);

            $user->receivedContacts()
                ->with('businessCard:id,full_name')
                ->latest()
                ->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $c) {
                        $name  = trim((string) $c->full_name);
                        $space = mb_strrpos($name, ' ');
                        $first = $space === false ? $name : mb_substr($name, 0, $space);
                        $last  = $space === false ? ''    : mb_substr($name, $space + 1);

                        fputcsv($out, [
                            $first,
                            $last,
                            $c->email,
                            $c->phone,
                            $c->businessCard->full_name ?? 'Cardifys',
                            $c->method === 'qr' ? 'QR' : 'Email',
                            optional($c->created_at)->format('Y-m-d H:i:s'),
                        ]);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Show user profile.
     */
    public function profile(): View
    {
        $user = Auth::user();
        
        return view('user.profile', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar_style' => ['nullable', 'string', \Illuminate\Validation\Rule::in(array_keys(\App\Support\Avatar::STYLES))],
        ]);

        $user = Auth::user();

        $userData = $request->only(['email', 'phone', 'bio', 'avatar_style']);

        if ($request->hasFile('avatar')) {
            // Handle avatar upload
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
