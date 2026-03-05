# my-portfolio

A Laravel 12 + Livewire (Volt) starter-based personal portfolio site using Laravel Fortify for authentication and Vite + Tailwind for frontend tooling.

## Quick Start

1. Clone
   git clone <repo-url> my-portfolio
2. Enter directory
   cd my-portfolio
3. Install PHP dependencies
   composer install
4. Install JS dependencies
   npm install
5. Copy environment file
   cp .env.example .env
6. Generate app key
   php artisan key:generate
7. Configure your database in .env then run migrations
   php artisan migrate
8. Start development
   npm run dev
   or build for production:
   npm run build

## Requirements

- Docker
- PHP ^8.2
- Composer
- Node.js + npm
- Supported DB (configured in .env)

## Useful Scripts

- composer run setup — runs installer, generates key, migrates, installs npm deps and builds assets
- composer run dev — runs server, queue listener, pail, and vite via concurrently
- composer run test — runs test suite
- npm run dev / npm run build — Vite dev/build

## Project Structure

- app/ — Laravel app code (Livewire components in app/Livewire)
- routes/web.php — route definitions (public pages plus Volt settings)
- resources/js, resources/css — frontend assets (Vite + Tailwind)
- database/migrations — migrations; factories and seeders available
- public/ — built assets and entry point

Public routes include:
- / — welcome/home
- /skills, /works, /navigation-links, /content-block, /contact

Volt provides settings routes for user profile, password, appearance, and two-factor.

## Authentication

- Uses Laravel Fortify for auth features and two-factor support.
- Volt routes handle settings pages (profile, password, appearance, two-factor).

## Testing

Run the project's tests:
composer run test

## Deployment

1. Build assets:
   npm run build
2. Push migrations:
   php artisan migrate --force
3. Cache/optimize:
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

## Contributing

- Follow existing code style.
- Run tests locally and include tests for new features.
- Open PRs against main with a descriptive title.

## License

MIT (see composer.json)
