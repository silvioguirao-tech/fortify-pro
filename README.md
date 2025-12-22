# fortify-pro
Projeto de Site completo com fortify.

## Setup inicial (dev)

1. Copie o `.env`:

```bash
cp .env.example .env
php -r "file_exists('.env') || copy('.env.example', '.env');"
```

2. Instale dependências e gere a chave de app:

```bash
composer install
php artisan key:generate
```

> Nota: se o `composer install` falhar localmente por falta de dependências do sistema (ex.: OpenSSL), verifique seu ambiente ou use um container compatível (ex.: devcontainer/Homestead/Herd).

3. Rode migrations e seeders (inclui roles + admin):

```bash
# Opcional: definir credenciais do admin via env
export SEED_ADMIN_EMAIL=admin@example.com
export SEED_ADMIN_PASSWORD=password

php artisan migrate --seed
```

4. Frontend:

```bash
npm install
npm run dev
```

---

As seeders adicionam roles padrão e um usuário admin (por padrão `admin@example.com` / `password`). Altere via variáveis `SEED_ADMIN_EMAIL` e `SEED_ADMIN_PASSWORD` antes de rodar os seeders em produção.
