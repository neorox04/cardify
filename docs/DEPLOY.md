# Deploy — Cardifys

Runbook para pôr e manter a Cardifys em produção. Assume um servidor Linux
(VPS ou plataforma gerida) com acesso SSH. Faz **cada passo por ordem** num
deploy novo; nos deploys seguintes repete só a secção **"Deploy / atualização"**.

---

## 1. Requisitos do servidor
- **PHP 8.2+** com as extensões: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`,
  `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `zip`, `intl`.
- **Composer 2**
- **Node 20+** (para compilar os assets com Vite)
- **Base de dados**: MySQL 8 ou PostgreSQL 14+ (⚠️ **não** uses SQLite em
  produção — mau para concorrência e backups).
- **Web server**: Nginx ou Apache a servir `public/` com HTTPS (certificado
  válido — Let's Encrypt chega).
- Opcional mas recomendado: **Redis** (cache + fila mais robustas).

---

## 2. Variáveis de ambiente (`.env` de produção)
Copia o `.env.example` e preenche. Os valores **críticos** para produção:

```dotenv
APP_ENV=production
APP_DEBUG=false                 # NUNCA true em produção (expõe stack traces/segredos)
APP_URL=https://cardifys.com    # o domínio real, com https

# Base de dados real
DB_CONNECTION=mysql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

# Fila: os emails são enfileirados (ver secção 5)
QUEUE_CONNECTION=database        # ou redis

# Email transacional real (NÃO gmail — limites + spam). Ex.: Resend/Postmark/SES
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="geral.cardifys@gmail.com"
MAIL_SUPPORT_ADDRESS="support.cardifys@gmail.com"
MAIL_GENERAL_ADDRESS="geral.cardifys@gmail.com"

# Stripe — chaves LIVE (pk_live_/sk_live_) + segredo do webhook (ver secção 6)
STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_PRICE_INDIVIDUAL_MONTHLY=price_...
STRIPE_PRICE_INDIVIDUAL_YEARLY=price_...
STRIPE_PRICE_COMPANY=price_...
CASHIER_CURRENCY=eur

# Sentry — monitorização de erros (ver secção 7)
SENTRY_LARAVEL_DSN=https://...@....ingest.sentry.io/...
SENTRY_TRACES_SAMPLE_RATE=0.2
```

Gera a chave da app uma vez: `php artisan key:generate`.

---

## 3. Deploy / atualização (passos repetíveis)
```bash
# a partir da raiz do projeto, na branch que vais servir
git pull origin main

composer install --no-dev --optimize-autoloader   # dependências PHP (sem dev)
npm ci && npm run build                            # compila os assets (Vite)

php artisan migrate --force                        # aplica migrações (--force = sem prompt)

# recria os caches (fazer SEMPRE depois de mudar .env ou código)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

php artisan storage:link                           # só na 1ª vez

# reinicia a fila para apanhar o código novo
php artisan queue:restart
```
> Se mudares o `.env`, corre `php artisan config:clear && php artisan config:cache`
> — com `config:cache` ativo, o Laravel deixa de ler o `.env` diretamente.

---

## 4. Permissões
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache
```

---

## 5. Queue worker (OBRIGATÓRIO) ⚠️
Os emails (onboarding, boas-vindas, contacto partilhado) são **enfileirados**
(`ShouldQueue`). **Sem um worker a correr, nenhum email é enviado.**

Exemplo com **supervisor** (`/etc/supervisor/conf.d/cardifys-worker.conf`):
```ini
[program:cardifys-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /caminho/para/cardify/artisan queue:work --tries=3 --max-time=3600 --sleep=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/caminho/para/cardify/storage/logs/worker.log
stopwaitsecs=3600
```
```bash
supervisorctl reread && supervisorctl update && supervisorctl start cardifys-worker:*
```
Depois de cada deploy corre `php artisan queue:restart` (já incluído na secção 3)
para o worker recarregar o código novo.

> **TODO do fundador:** por agora o worker ainda não está a correr. Antes do
> lançamento, montar o supervisor acima (ou `php artisan queue:work` num
> processo persistente), senão os emails ficam na fila sem saír.

---

## 6. Webhook do Stripe
1. No **Stripe Dashboard → Developers → Webhooks → Add endpoint**:
   - URL: `https://cardifys.com/stripe/webhook`
   - Eventos (mínimo): `checkout.session.completed`,
     `customer.subscription.created`, `customer.subscription.updated`,
     `customer.subscription.deleted`, `invoice.payment_succeeded`,
     `invoice.payment_failed`.
2. Copia o **Signing secret** (`whsec_...`) para `STRIPE_WEBHOOK_SECRET`.
3. A rota `stripe/webhook` já está isenta de CSRF (`bootstrap/app.php`).
4. Testa com o Stripe CLI: `stripe listen --forward-to https://cardifys.com/stripe/webhook`.

---

## 7. Sentry (monitorização de erros)
Já instalado e ligado ao handler de exceções (`bootstrap/app.php`). Só precisas de:
1. Criar um projeto Laravel em sentry.io e copiar o **DSN**.
2. Pôr `SENTRY_LARAVEL_DSN=...` no `.env`.
3. (Opcional) validar: `php artisan sentry:test`.

Sem DSN, o Sentry fica inativo (não parte nada) — por isso é seguro em dev.

---

## 8. Email — entregabilidade
Para os emails não caírem no spam, no DNS do domínio configura **SPF**, **DKIM**
e **DMARC** conforme as instruções do provider (Resend/Postmark/SES).

---

## 9. Backups
Agenda um dump diário da base de dados (ex.: `mysqldump`/`pg_dump` + cópia para
storage externo/S3). Testa o restauro pelo menos uma vez.

---

## 10. Checklist pós-deploy
- [ ] `https://cardifys.com/up` responde 200 (health check).
- [ ] `APP_DEBUG=false` confirmado (uma rota inexistente não mostra stack trace).
- [ ] Registo de teste → email de boas-vindas chega (worker a correr).
- [ ] Checkout de teste (cartão de teste Stripe) → subscrição ativa + onboarding.
- [ ] Webhook do Stripe a receber `200` no dashboard.
- [ ] Erros aparecem no Sentry (forçar um e verificar).
- [ ] Export CSV dos contactos funciona.

### Rollback rápido
```bash
git checkout <commit-anterior>
composer install --no-dev --optimize-autoloader && npm ci && npm run build
php artisan migrate:rollback   # só se a migração nova causou o problema
php artisan config:cache && php artisan queue:restart
```
