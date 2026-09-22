# Laravel Admin Kit

A modern and reusable administration panel built with Laravel, Blade, Tailwind CSS and Alpine.js.

Laravel Admin Kit provides a solid starting point for building custom web applications that require authentication, user management, roles, permissions, notifications, audit logs and application settings.

## Features

### Authentication

* Login
* Logout
* Email verification support
* User profile
* Password protection through Laravel authentication
* Responsive authentication screens

### Dashboard

* Administration overview
* User statistics
* Content statistics
* Notification statistics
* Audit activity
* Recent activity
* Quick actions

### User management

* Create users
* Edit users
* Delete users
* View user profiles
* Assign roles
* Search and filter users

### Roles and permissions

* Create roles
* Edit roles
* Delete custom roles
* Assign permissions to roles
* Permission grouping
* Role statistics
* Administrative role protection

### Content management

* Create content
* Edit content
* Delete content
* Publish/unpublish content
* View content details

### Notifications

* Send notifications to users
* Notification history
* Read/unread states
* Mark notifications as read
* Mark all notifications as read
* Notification counter
* Notification dropdown

### Audit system

The application records important actions such as:

* User creation
* User modification
* User deletion
* Role creation
* Role modification
* Content creation
* Content modification
* Notifications
* Login
* Logout
* Configuration changes

The audit system provides:

* Search
* Action filters
* User filters
* Date filters
* Detailed activity pages

### Application settings

Administrators can configure:

* Application name
* Application description
* Contact email
* Timezone
* Maintenance mode

## Technology stack

* Laravel
* PHP
* Blade
* Tailwind CSS
* Alpine.js
* MySQL
* Vite

## Requirements

Before installing the application, make sure your environment includes:

* PHP
* Composer
* Node.js and npm
* MySQL
* A web server or Laravel Herd

The PHP version should match the requirements defined by the project's `composer.json`.

## Installation

Clone the repository:

```bash
git clone YOUR_REPOSITORY_URL
cd YOUR_PROJECT_FOLDER
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell you can use:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Create the database configured in `.env`.

Then run:

```bash
php artisan migrate --seed
```

Build the frontend:

```bash
npm run build
```

Start the development server:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Demo administrator

For local development, the seeders create a demo administrator with these fallback credentials:

```text
Email: admin@example.com
Password: password
```

Change these credentials before deploying the application to production.

For production, configure these variables before running the seeders:

```env
ADMIN_NAME="Your name"
ADMIN_EMAIL=admin@your-domain.com
ADMIN_PASSWORD="use-a-password-with-at-least-12-characters"
```

The production seeder stops with an error when `ADMIN_PASSWORD` is missing or too short.

## Development

For frontend development:

```bash
npm run dev
```

For the Laravel development server:

```bash
php artisan serve
```

## Production

Before deploying to production:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan optimize
```

Make sure:

* `APP_ENV=production`
* `APP_DEBUG=false`
* A secure `APP_KEY` is configured
* Production database credentials are configured
* Demo credentials are changed
* Storage permissions are correctly configured

## Deploying to Railway

The repository includes `railway.json` with the build, migration and health-check commands.

1. Create a Railway project and deploy this GitHub repository.
2. Add a MySQL service to the project.
3. Configure these variables in the application service:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-railway-domain.up.railway.app
APP_KEY=generate-a-secure-key-locally
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
ADMIN_NAME="Your name"
ADMIN_EMAIL=admin@your-domain.com
ADMIN_PASSWORD="use-a-password-with-at-least-12-characters"
```

4. Deploy the service. Railway will install dependencies, build Vite assets, run migrations and start Laravel.
5. Run `php artisan db:seed --force` once from the Railway shell if you want the demo records in the hosted environment.
6. Generate a domain from Railway or connect your own domain with HTTPS.

Never commit `.env`, `APP_KEY`, database credentials or `ADMIN_PASSWORD` to GitHub.

## Deploying to Render

The repository includes a `Dockerfile` for Render. When creating the Web Service, select the repository and choose **Docker** as the runtime.

Use the PostgreSQL database provided by Render and configure:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=your-generated-key
APP_URL=https://your-render-domain.onrender.com
DB_CONNECTION=pgsql
DB_HOST=your-render-postgres-host
DB_PORT=5432
DB_DATABASE=your-render-postgres-database
DB_USERNAME=your-render-postgres-user
DB_PASSWORD=your-render-postgres-password
ADMIN_NAME="Your name"
ADMIN_EMAIL=admin@your-domain.com
ADMIN_PASSWORD="use-a-password-with-at-least-12-characters"
```

The Docker image installs dependencies, compiles the frontend, runs migrations and starts Apache. Render's free web services may sleep after inactivity.

## Project structure

```text
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/
├── Services/
└── View/

database/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
└── web.php
```

## Security

This project uses Laravel's authentication, middleware and validation systems.

Sensitive environment configuration must never be committed to the repository.

Do not commit:

```text
.env
```

Production deployments should use secure credentials and HTTPS.

## License

This project is distributed under the license included with the commercial release.

See the `LICENSE` file for the exact terms.

## Support

For commercial releases, installation instructions and support information should be provided by the seller.

## Roadmap

Possible future improvements include:

* Advanced dashboard widgets
* More CRUD modules
* API authentication
* REST API
* Two-factor authentication
* Advanced notification channels
* More detailed analytics
* File management
* Multi-language support
* Theme customization
