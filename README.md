<div align="center">

# Laravel Standard Starter

**A production-minded Laravel 13 + Filament 5 foundation, so every new project starts at step 10 instead of step 0.**

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-5.x-FDAE4B)
![License](https://img.shields.io/badge/License-MIT-green)

</div>

---

## Table of Contents

- [Why This Exists](#why-this-exists)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Feature Guide](#feature-guide)
    - [Custom Dashboards](#1-custom-dashboards)
    - [Date-Time Formatter](#2-date-time-formatter)
    - [Currency Formatter](#3-currency-formatter)
    - [Permissions (Spatie)](#4-permissions-spatie)
    - [Operation Class Stub](#5-operation-class-stub)
    - [Hashing Helper](#6-hashing-helper)
    - [JsonResponder](#7-jsonresponder)
    - [Validation Class](#8-validation-class)
    - [EnumSafe Trait](#9-enumsafe-trait)
    - [Site & API Hit Recording](#10-site--api-hit-recording)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## Why This Exists

Every new project tends to begin the same way: install the admin panel, wire up roles and permissions, add formatters, standardize API responses, set up error tracking, and so on. This repository captures all of that repeated groundwork in one clean, reusable application so a new project can start from a solid baseline.

Clone it, rename it, and start building features.

## Tech Stack

| Layer | Package |
| --- | --- |
| Language | PHP `^8.3` |
| Framework | `laravel/framework ^13.17` |
| Admin Panel | `filament/filament ^5.0` |
| Media | `filament/spatie-laravel-media-library-plugin ^5.0` |
| Charts / Trends | `flowframe/laravel-trend ^0.5.0` |
| Roles & Permissions | `spatie/laravel-permission ^8.3` |
| User-Agent Parsing | `jenssegers/agent ^2.6` |
| Error Monitoring | `sentry/sentry-laravel ^4.29` |
| REPL | `laravel/tinker ^3.0` |

## Features

- **Filament 5 admin panel** with media library support
- **Custom dashboards** with multiple layout options
- **Custom date-time formatter** for consistent display across the app
- **Custom currency formatter**
- **Custom permission layer** built on Spatie Laravel Permission
- **Custom Artisan stub** to generate *Operation* classes
- **Custom hashing helper** class
- **`JsonResponder`** for uniform API responses
- **Validation class** for centralized, reusable rules
- **`EnumSafe` trait** to safely handle `null` being passed to enums
- **Site hit & API hit recording** via `SiteHitRecordStore` / `ApiHitRecordStore`
- **Sentry** integration for error tracking
- **Trend analytics** with Laravel Trend

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/<your-username>/<your-repo>.git
cd <your-repo>

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies and build assets
npm install
npm run build

# 4. Configure the environment
cp .env.example .env
php artisan key:generate

# 5. Set your database credentials in .env, then migrate and seed
php artisan migrate --seed

# 6. Link storage (needed for media uploads)
php artisan storage:link

# 7. Create an admin user for Filament
php artisan make:filament-user

# 8. Serve the application
php artisan serve
```

The admin panel is available at `/admin` by default.

### Environment Variables

Set these in `.env` as needed:

```env
APP_NAME="Laravel Standard Starter"
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password

SENTRY_LARAVEL_DSN=
```

---

## Feature Guide

> Class names and namespaces below follow the structure of this repository. Adjust the examples to match your own paths.

### Custom Dashboards

The Filament panel ships with dashboards in **different layouts**, so you can pick the one that fits the project (analytics-heavy, operations-focused, minimal, and so on) rather than building one each time. Widgets are built on Filament's widget system and use `flowframe/laravel-trend` for time-series data.

### Date-Time Formatter

A single place to control how dates and times are displayed, so formats stay consistent across Blade views, Filament tables, and API output.

```php
// Illustrative usage
Format::date($model->created_at);
```

Change the format once and it updates everywhere.

### Permissions (Spatie)

Role and permission management is built on `spatie/laravel-permission`, extended with a custom layer so permissions are defined and synced in a consistent, repeatable way and wired into Filament resources.

```bash
php artisan migrate --seed   # seeds default roles and permissions
```

### Operation Class Stub

A custom Artisan stub generates **Operation classes**, single-purpose classes that encapsulate one business action. This keeps controllers and Filament actions thin.

```bash
php artisan make:operation CreateOrderOperation
```

```php
class CreateOrderOperation
{
    public function handle():void
    {
        // business logic lives here
    }
}
```

### Hashing Helper

A small helper class that wraps hashing logic (for example, hashing identifiers or tokens) behind one consistent API, instead of repeating hashing code across the codebase.
```php
return Hash::generate($key, $time(NULL));
return Hash::check($hash, $key, $time(NULL));
```

### 7. JsonResponder

A single class that produces **uniform JSON responses** for success, error, and validation failures, so every API endpoint returns the same shape.

```php
return JsonResponder::success($data, 'Fetched successfully');
return JsonResponder::error('Something went wrong', 500);
```

### 8. Validation Class

Centralized validation rules and messages in a reusable class, keeping Form Requests and controllers clean and avoiding duplicated rule sets.

### 9. EnumSafe Trait

Passing `null` to `Enum::from()` throws an error. The `EnumSafe` trait adds null-safe helpers to your enums so optional values can be handled without extra `if` checks.

```php
enum Status: string
{
    use EnumSafe;

    case Active = 'active';
    case Inactive = 'inactive';
}

Status::safeTryFrom(null); // returns null instead of throwing
```

### 10. Site & API Hit Recording

Two recording mechanisms track traffic:

- **`SiteHitRecordStore`** records visits to web pages.
- **`ApiHitRecordStore`** records requests to API endpoints.

Using `jenssegers/agent`, each hit can capture device, browser, and platform details, which feed the dashboard widgets and trend charts.

---

## Project Structure

```text
app/
├── Console/            
├── Filament/           
├── Foundation/
│   ├── Enum/     
│   ├── Helper/           
│   └── Trait/          
├── Http/
│   ├── Controllers/     
│   └── Middlewares/     
├── Liveware/
├── Models/
├── Operations/         
├── Providers/           
stubs/                  
```

> Update this tree to match the actual layout of the repository.

## Contributing

Contributions, issues, and feature requests are welcome. Fork the repo, create a feature branch, and open a pull request.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
