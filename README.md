# Portfólio Pessoal (`luankobs.dev`)

Monorepo do meu portfólio pessoal, dividido entre uma API administrativa em **Laravel 12 + Filament 4 (PHP 8.2)** e um site estático em **Astro + Tailwind CSS v4 + TypeScript**.

## Arquitetura

- **`backend/`**: Laravel 12 rodando em PHP 8.2 (via Docker), SQLite como banco de dados, Filament 4 em `/admin` (com MFA via app autenticador) para gestão do conteúdo e endpoints públicos somente-leitura `GET /api/v1/portfolio`, `GET /cv` e `GET /up`.
- **`frontend/`**: Astro (SSG 100% estático) + TypeScript strict + Tailwind CSS v4 + validação de contrato via Zod e fontes self-hosted (`@fontsource-variable/geist` e `@fontsource-variable/geist-mono`).
- **`docker/`**: Ambiente containerizado com PHP 8.2-FPM, Nginx, worker de fila e script de backup (`docker/scripts/backup.sh`).

## Pré-requisitos

- Docker & Docker Compose
- Node.js 24 LTS (gerenciado via `nvm` — veja `frontend/.nvmrc`)
- `make`

## Como rodar localmente

1. **Subir o backend (Docker PHP 8.2 + Nginx + Queue):**
   ```bash
   make up
   ```
   - Painel Admin: `http://localhost:8000/admin` (acessar `http://localhost:8000/` redireciona para `/admin`)
   - API pública: `http://localhost:8000/api/v1/portfolio`
   - Health check: `http://localhost:8000/up`

2. **Recriar banco e popular com os dados iniciais (placeholders do design):**
   ```bash
   make fresh
   ```

3. **Rodar o frontend em modo desenvolvimento (`http://localhost:4321`):**
   ```bash
   make dev
   ```

4. **Rodar lint, análise estática e testes:**
   ```bash
   make lint
   make test
   ```

## Como editar conteúdo

1. Crie seu usuário administrador:
   ```bash
   docker compose exec app php artisan app:create-admin
   ```
2. Acesse `http://localhost:8000/admin`, faça login e (opcionalmente) ative o MFA no menu do seu perfil.
3. Edite os dados em **Perfil**, **Links Sociais**, **Experiências** e **Projetos**.
4. Ao salvar qualquer alteração, o cache da API é invalidado imediatamente e o job `TriggerFrontendRebuild` é enfileirado (com debounce de 60s). Você também pode clicar no botão **"Publicar site agora"** no topo do painel.
5. Para atualizar o fixture JSON local do frontend:
   ```bash
   make export-fixture
   ```

## Como publicar em produção (`luankobs.dev`)

### 1. GitHub Secrets necessários
Configure no repositório do GitHub (`Settings → Secrets and variables → Actions`):

- **Frontend (Cloudflare Pages)**:
  - `CLOUDFLARE_API_TOKEN`: Token de API da Cloudflare com permissão `Cloudflare Pages: Edit`
  - `CLOUDFLARE_ACCOUNT_ID`: ID da conta na Cloudflare
  - `CLOUDFLARE_PROJECT_NAME`: `luankobs-dev` (ou nome do projeto no Pages)
  - `PRODUCTION_API_URL`: `https://api.luankobs.dev`
  - `PUBLIC_SITE_URL`: `https://luankobs.dev`
- **Backend (VPS via SSH)**:
  - `VPS_HOST`: IP ou hostname da VPS
  - `VPS_USER`: Usuário SSH (ex.: `deploy`)
  - `VPS_PORT`: Porta SSH (padrão `22`)
  - `VPS_SSH_KEY`: Chave privada SSH
  - `VPS_APP_DIR`: Diretório do projeto na VPS (ex.: `/opt/kobs-dev`)

### 2. Variáveis `.env` do Backend em Produção (`api.luankobs.dev`)
No arquivo `backend/.env` da VPS:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.luankobs.dev
FRONTEND_URL=https://luankobs.dev

# Opção A: Deploy Hook direto do Cloudflare Pages
FRONTEND_DEPLOY_WEBHOOK_URL=https://api.cloudflare.com/client/v4/pages/webhooks/deploy_hooks/...

# Opção B: Ou disparar o GitHub Actions (deploy-frontend.yml) via repository_dispatch
GITHUB_DISPATCH_REPO=seu-usuario/kobs-dev
GITHUB_DISPATCH_TOKEN=ghp_...
```

### 3. Backup diário na VPS
Adicione ao `crontab -e` na VPS para fazer backup diário do SQLite + imagens de `storage/app/public`:
```cron
0 3 * * * /opt/kobs-dev/docker/scripts/backup.sh >> /var/log/kobs-backup.log 2>&1
```

## Ideias futuras (Fora do escopo atual)

- Formulário de contato (atualmente usa link `mailto:`).
- Versão em inglês (`i18n`).
- Blog / páginas de detalhe por projeto.
- Analytics sem cookies (ex.: Plausible ou Umami).
