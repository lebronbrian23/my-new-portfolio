# My Portfolio

This repository powers my personal portfolio website. It is built on top of a Laravel 12 starter kit enhanced with Livewire (Volt) components and Laravel Fortify for authentication.

The site enables the owner to manage and display:

- **Skills** – list of technical proficiencies with logos and descriptions
- **Works** – projects or pieces of work including title, image, link, and category
- **Navigation links** – items used in the site menu (customizable order and labels)
- **Content blocks** – arbitrary text and markup sections for the home page or other areas (resume blocks allow uploading a PDF instead of an image)
- **Contact form** – visitors can send messages, which are stored and can be moderated by the authenticated user

All administration pages are powered by Livewire components under `app/Livewire` and protected by Fortify authentication. Volt provides user settings (profile, password, appearance, two–factor). The public-facing frontend is styled with Tailwind CSS and built with Vite.

---

## Getting Started

To run the portfolio locally:

1. **Clone the repo**
   ```bash
   git clone https://github.com/lebronbrian23/my-new-portfolio.git
   cd my-portfolio
   ```
2. **Install PHP dependencies**
   ```bash
   composer install
   ```
3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```
4. **Copy and configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update database settings (and mail if required) in `.env`.
5. **Migrate database**
   ```bash
   php artisan migrate
   ```
6. **Run development server**
   ```bash
   npm run dev
   php artisan serve
   ```
   or build for production with `npm run build`.

### Requirements

- PHP >= 8.2 with required extensions
- Composer
- Node.js & npm
- A supported database (MySQL, Postgres, SQLite, etc.)
- Docker is optional but recommended for local environment parity

### Useful Commands

| Command | Description |
|---------|-------------|
| `composer run setup` | Installer script: composer install, npm install, migrate, build assets, etc. |
| `composer run dev` | Starts PHP server, queue worker and Vite in parallel |
| `composer run test` | Runs the PHPUnit test suite |
| `npm run dev` / `npm run build` | Vite development server or build assets |

---

## Project Structure

- `app/` – application code; Livewire components live in `app/Livewire`
- `routes/web.php` – route definitions (public pages and Volt settings)
- `resources/js`, `resources/css` – frontend entry points for Vite/Tailwind
- `database/migrations`, `factories`, `seeders` – schema and test data
- `public/` – compiled assets and entry point

Public pages include:
- `/` – homepage rendering content blocks, skills, works, etc.
- `/skills`, `/works`, `/navigation-links`, `/content-block`, `/contact` – API endpoints used by the Livewire admin UI and occasionally publicly

Volt provides user settings routes for profile, password, appearance, and two-factor authentication.

---

## Authentication

Administration is protected using Laravel Fortify. Users may register, log in, and manage their account through Volt's UI. Two-factor authentication is supported.

---

## Testing

Execute the test suite before merging changes:
```bash
composer run test
```

---

## Deployment

1. Build frontend assets:
   ```bash
   npm run build
   ```
2. Run migrations on the production database:
   ```bash
   php artisan migrate --force
   ```
3. Cache configuration and routes:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Restart queue workers and web server as needed.

---

## Contributing

Contributions are welcome! Please:

1. Fork the repository and create a feature branch
2. Follow the existing coding style (PSR-12, Tailwind classes, etc.)
3. Add or update tests for your changes
4. Submit a pull request with a clear description

---

## License

This project is licensed under the MIT License – see `composer.json` for details.

---

*Last updated March 2026*
