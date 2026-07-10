<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SupportController extends Controller
{
    // ── Public: submit a support request ──────────────────────────────────

    public function create(): View
    {
        return view('support.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $ticket = SupportTicket::create($data + ['status' => 'received']);

        // Notify the team by email (support also lands in the admin board).
        $admins = User::where('type', 'super_admin')->pluck('email');
        if ($admins->isNotEmpty()) {
            $body = "Novo pedido de suporte\n\n"
                . "De: {$ticket->name} <{$ticket->email}>\n"
                . "Assunto: {$ticket->subject}\n\n"
                . "{$ticket->message}\n";
            try {
                Mail::raw($body, fn ($m) => $m->to($admins->all())
                    ->replyTo($ticket->email, $ticket->name)
                    ->subject("[Suporte] {$ticket->subject}"));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect()->route('support.contact')->with('support_sent', true);
    }

    // ── Admin: kanban board ───────────────────────────────────────────────

    public function index(): View
    {
        $tickets = SupportTicket::latest()->get()->groupBy('status');

        return view('admin.support', compact('tickets'));
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys(SupportTicket::STATUSES))],
        ]);

        $ticket->update($validated);

        return response()->json(['ok' => true]);
    }

    public function destroy(Request $request, SupportTicket $ticket)
    {
        $ticket->delete();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('admin.support')->with('success', 'Pedido de suporte removido.');
    }
}
