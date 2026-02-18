# MoneyManagement

A personal finance management web app to track income, expenses, budgets, and savings goals. Built with a Brazilian Real (R$) currency context.

## Features

- **Dashboard** — Monthly balance overview, income vs. expense trends (6-month chart), and category breakdowns
- **Transactions** — Full CRUD for income and expense entries with categories, notes, and date filtering
- **Budgets** — Set monthly budgets per category with percentage-based alerts (warns at 80%+)
- **Categories** — Custom categories with icons and colors for both income and expenses
- **Stash (Caixinhas)** — Savings goals with target amounts and progress tracking

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Vue 3, Inertia.js 2, Tailwind CSS 4 |
| Database | MySQL 8.4 |
| Build | Vite 7 |
| Charts | Chart.js 4 |
| Dev Environment | Docker / Laravel Sail |

## Requirements

- Docker Desktop
- Node.js
- Composer

## Setup

**1. Clone and install dependencies:**

```bash
git clone <repo-url>
cd MoneyManagement
composer install
```

**2. Configure environment:**

```bash
cp .env.example .env
php artisan key:generate
```

**3. Start Docker containers:**

```bash
./vendor/bin/sail up -d
```

> Tip: Add `alias sail="./vendor/bin/sail"` to your `~/.zshrc` so you can just run `sail up -d`.

**4. Run migrations:**

```bash
sail artisan migrate
```

**5. Install frontend dependencies and start dev server:**

```bash
npm install
npm run dev
```

The app will be available at [http://localhost](http://localhost).

## Development

Run everything at once (PHP server + queue + Vite hot reload):

```bash
composer dev
```

Or run individually:

```bash
sail artisan serve          # PHP server
sail artisan queue:listen   # Queue worker
npm run dev                 # Vite dev server (port 5173)
```

## Available Scripts

| Command | Description |
|---|---|
| `composer setup` | Full first-time setup (install, key, migrate, build) |
| `composer dev` | Start all dev processes concurrently |
| `composer test` | Run PHPUnit test suite |
| `npm run dev` | Start Vite dev server |
| `npm run build` | Build production assets |

## Project Structure

```
app/
├── Http/Controllers/   # Dashboard, Transaction, Budget, Category, Stash
├── Models/             # Transaction, Category, Budget, Stash, User
└── Helpers/            # Currency formatter (centavos → R$)

resources/js/
├── Pages/              # Inertia page components (Vue)
├── Components/         # Shared components (BottomNav, MonthPicker, etc.)
└── Layouts/            # App.vue main layout

database/
├── migrations/         # Users, Categories, Transactions, Budgets, Stashes
└── seeders/
```

## Notes

- All amounts are stored in **centavos** (integer) to avoid floating-point precision issues.
- The app locale is `pt_BR` (Brazilian Portuguese).
- Sessions, cache, and queues all use the database driver by default.
