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

The seeders create a demo administrator:

```text
Email: admin@example.com
Password: password
```

Change these credentials before deploying the application to production.

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
