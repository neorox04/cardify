# Cardifys

## What it is
Cardifys is a **Portuguese-first digital business card SaaS**. A user creates
digital business cards (each with a branded QR code), shares them with a tap or
a scan, and the person on the other side can **save the contact (vCard)** and,
crucially, **share their own contact back** — the *reciprocity loop*. Every card
tracks analytics (views, scans, saves, conversion), and the owner can **export
all received leads as a CSV** ready to import into any CRM.

The product, UI and marketing copy are in **Portuguese** (with an EN i18n layer
on the homepage). Communicate with the founder in Portuguese.

## Stack
- **Laravel 12**, **PHP ^8.2**, Blade + Eloquent
- **Laravel Cashier ^16** (Stripe subscriptions)
- **PHPUnit** feature/unit tests
- SQLite in dev; a real DB (MySQL/Postgres) is expected in production
- Design system: **Geist** font + an **oklch purple dark theme**
  (`oklch(0.72 0.19 300)`; hex ~ `#B884FF` / `#854ECE`)

## Domain model (key tables / models)
- **User** — `type` is `user` or `super_admin` (super_admin = the platform
  owner/founder). Implements `MustVerifyEmail`.
- **BusinessCard** — a user's card (slug, theme, is_public, is_active, counters
  for views/qr_scans/contacts_saved).
- **Company** — single-account-with-seats. Membership + admin flag live on the
  **`company_user`** pivot (`is_admin`). There is **no company `type` column** —
  a company admin is derived from `company_user.is_admin`. Also
  `company_invites`.
- **SharedContact** (`shared_contacts`) — the reciprocity loop: a visitor's
  contact (full_name, email, phone, method `qr|email`) shared back to the card
  owner (`recipient_user_id`). These are the "leads" the CSV export produces.
- **CardEvent** — analytics events.
- **SupportTicket** — support requests (statuses received/in_progress/done).
- **RoadmapItem** — internal kanban (statuses todo/doing/done; priorities
  low/medium/high — colours: Alta=red, Média=yellow, Baixa=green).
- Cashier: `subscriptions`, `subscription_items`.

## Key business rules
- **Subscription gating**: creating a card requires `subscribed('default')`;
  public card display requires `BusinessCard::ownerHasActiveSubscription()`.
  (Closing this abuse hole was deliberate — keep both checks in place.)
- **Free trial**: individual plans (monthly/yearly) get a **7-day trial, card
  required upfront** (`->trialDays(7)` in `SubscriptionController::checkout`).
  The sub sits in `trialing` (Cashier treats it as active, so gating/cards work
  unchanged). Company plans have no trial. Marketing copy may say "7 dias grátis"
  but **not** "sem cartão" (a card is required).
- **Card limits**: the individual plan is capped at **5 personal cards**
  (`BusinessCardController::PERSONAL_CARD_LIMIT`); company cards are capped by
  paid seats instead.
- **Plans**: individual monthly, individual yearly, company (per-seat). Price IDs
  come from `config('services.stripe.prices.*)`.
- **Stripe webhook**: `WebhookController` extends Cashier's (signature verified
  by the base class). It adds an onboarding email + a belt-and-suspenders sync
  on `checkout.session.completed` so no paying customer is ever locked out.
- **Roles/areas**: `super_admin` reaches `/admin` — `AdminPanelController`
  (founder metrics "CRM", user management incl. password-protected deletion),
  `RoadmapController` (kanban), `SupportController` (tickets). Regular users get
  the dashboard; company admins get the company dashboard.
- **CRM integration reality**: there is **no external CRM API/webhook/sync**.
  The honest, shipped feature is **CSV export of received leads** (+ per-contact
  vCard). Homepage copy says CSV export is real and "automatic API sync" is
  roadmap — keep that framing; do not re-introduce false CRM claims.

## Conventions
- **Emails are config-driven**: `config('mail.support_address')`
  (`support.cardifys@gmail.com`) and `config('mail.general_address')`
  (`geral.cardifys@gmail.com`). Public-facing address is the geral one. Never
  hardcode addresses in views. `rodrigo@cardifys.app` on the demo card is a
  mockup — leave it.
- **Homepage** `resources/views/welcome2.blade.php` is a large, minified,
  JSON-escaped blob with a PT/EN i18n dictionary (`data-i18n` keys). Edit it with
  **literal string replacement** (a small Python script), not by hand, and match
  the exact escaped form (`\"`, `/`).
- **Values the founder cares about**: honesty — no "fachada"/fake features;
  clean, tested code; and a consistent design system. When copy claims a feature,
  the feature must actually exist.
- **Bug pattern to avoid**: `back()` without a referer falls to the home page —
  prefer explicit `redirect()->route(...)` for form submits.

## Testing
- Run: `php artisan test`. A `.env` is required; the full suite needs the Stripe
  **price IDs** populated (copy the defaults from `config/services.php` into
  `.env`, or the SubscriptionTier/checkout tests fail with empty env values).
- Current state: ~**264 passing, 8 skipped** (the 8 are real-Stripe integration
  tests, skipped by design).

## Git workflow
- Develop on branch **`claude/start-session-mWMSK`**; push there, and to `main`
  when the founder asks (main has stayed a fast-forward of the branch).
- Git committer must be `Claude <noreply@anthropic.com>`.
- End commit messages with:
  ```
  Co-Authored-By: Claude Opus 4.8 <noreply@anthropic.com>
  Claude-Session: https://claude.ai/code/session_01MQkYt6eYkGDnmc7dz84fb6
  ```
- Do **not** put any model identifier in commits, PRs, code, or comments.

## Launch-readiness notes (open items, as of this writing)
- **Blockers (config/ops, not product code)**: set production `.env`
  (`APP_ENV=production`, `APP_DEBUG=false`, real DB, live Stripe keys +
  registered webhook secret); move off gmail SMTP to a transactional provider
  with SPF/DKIM. **Mail is now queued** (all Mailables implement `ShouldQueue`),
  so production MUST run a queue worker (`php artisan queue:work`, e.g. under
  supervisor) or no email is ever sent.
- **Legal (RGPD)**: `privacidade.blade.php` / `termos.blade.php` are now proper
  RGPD/consumer-aware drafts (controller identity, data categories incl. the
  reciprocity-loop third parties, legal bases, processors, retention, data
  rights, CNPD). **Placeholders `[Nome legal da entidade]` / `[morada]` /
  `[NIF]` / `[comarca]` must be filled in**, and a lawyer should review before
  launch.
- **Hardening**: Sentry is installed and wired into the exception handler
  (`bootstrap/app.php`) — inactive until `SENTRY_LARAVEL_DSN` is set in prod.
  A deploy runbook lives at `docs/DEPLOY.md`. Still open: automated DB backups.
