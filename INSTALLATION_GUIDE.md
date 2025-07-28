# Centurion (Bagisto) Installation & Development Guide

## Table of Contents
1. [Prerequisites](#prerequisites)
2. [Installation](#installation)
3. [Development Setup](#development-setup)
4. [Daily Development Commands](#daily-development-commands)
5. [Open Source Workflow](#open-source-workflow)
6. [Custom Package Development](#custom-package-development)
7. [Troubleshooting](#troubleshooting)

## Prerequisites

### System Requirements
- **Docker Desktop** (Latest version)
- **Git** (Latest version)
- **Node.js** (v18 or higher) - Optional, for local development
- **Composer** (Latest version) - Optional, for local development

### Docker Installation
- **macOS**: Download from [Docker Desktop](https://www.docker.com/products/docker-desktop)
- **Windows**: Download from [Docker Desktop](https://www.docker.com/products/docker-desktop)
- **Linux**: Follow [Docker Engine installation](https://docs.docker.com/engine/install/)

## Installation

### 1. Clone the Repository
```bash
# Clone the original Bagisto repository
git clone https://github.com/bagisto/bagisto.git centurion
cd centurion

# Add the original repository as upstream
git remote add upstream https://github.com/bagisto/bagisto.git
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Docker Setup with Laravel Sail
```bash
# Install Laravel Sail
composer require laravel/sail --dev

# Install Sail with required services
php artisan sail:install --with=mysql,redis

# Start Docker containers
./vendor/bin/sail up -d
```

### 5. Database Setup
```bash
# Run migrations
./vendor/bin/sail artisan migrate

# Seed database with initial data
./vendor/bin/sail artisan db:seed

# Create storage link
./vendor/bin/sail artisan storage:link
```

### 6. Build Assets
```bash
# Build production assets
./vendor/bin/sail npm run build

# Or run development server
./vendor/bin/sail npm run dev
```

## Development Setup

### Initial Configuration
```bash
# Optimize application
./vendor/bin/sail artisan optimize

# Clear all caches
./vendor/bin/sail artisan optimize:clear
```

### Access Information
- **Main Application**: http://localhost
- **Admin Panel**: http://localhost/admin
- **Email Testing (Mailpit)**: http://localhost:8025
- **Kibana Dashboard**: http://localhost:5601

### Default Credentials
- **Admin Email**: `admin@example.com`
- **Admin Password**: `admin123`

## Daily Development Commands

### Docker Management
```bash
# Start all services
./vendor/bin/sail up -d

# Stop all services
./vendor/bin/sail down

# View running containers
./vendor/bin/sail ps

# View logs
./vendor/bin/sail logs

# View logs for specific service
./vendor/bin/sail logs mysql
```

### Artisan Commands
```bash
# Run any artisan command
./vendor/bin/sail artisan [command]

# Clear caches
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear

# Optimize application
./vendor/bin/sail artisan optimize

# Clear all optimizations
./vendor/bin/sail artisan optimize:clear
```

### Database Commands
```bash
# Run migrations
./vendor/bin/sail artisan migrate

# Rollback migrations
./vendor/bin/sail artisan migrate:rollback

# Refresh migrations (rollback + migrate)
./vendor/bin/sail artisan migrate:refresh

# Seed database
./vendor/bin/sail artisan db:seed

# Reset database (migrate:fresh + seed)
./vendor/bin/sail artisan migrate:fresh --seed
```

### Frontend Development
```bash
# Install dependencies
./vendor/bin/sail npm install

# Run development server
./vendor/bin/sail npm run dev

# Build for production
./vendor/bin/sail npm run build

# Watch for changes
./vendor/bin/sail npm run dev -- --watch
```

### Testing
```bash
# Run tests
./vendor/bin/sail test

# Run tests with coverage
./vendor/bin/sail test --coverage

# Run specific test file
./vendor/bin/sail test tests/Feature/ExampleTest.php
```

### Package Management
```bash
# Install Composer package
./vendor/bin/sail composer require package-name

# Install Composer dev package
./vendor/bin/sail composer require --dev package-name

# Update dependencies
./vendor/bin/sail composer update

# Install NPM package
./vendor/bin/sail npm install package-name

# Install NPM dev package
./vendor/bin/sail npm install --save-dev package-name
```

### Container Access
```bash
# Access container shell
./vendor/bin/sail shell

# Access MySQL
./vendor/bin/sail mysql

# Access Redis CLI
./vendor/bin/sail redis
```

## Open Source Workflow

### 1. Fork the Repository
1. Go to [Bagisto GitHub Repository](https://github.com/bagisto/bagisto)
2. Click "Fork" button in the top right
3. This creates your own copy of the repository

### 2. Clone Your Fork
```bash
# Clone your forked repository
git clone https://github.com/YOUR_USERNAME/bagisto.git centurion
cd centurion

# Add the original repository as upstream
git remote add upstream https://github.com/bagisto/bagisto.git
```

### 3. Create Development Branch
```bash
# Create and switch to development branch
git checkout -b development

# Push development branch to your fork
git push -u origin development
```

### 4. Keep Your Fork Updated
```bash
# Fetch latest changes from upstream
git fetch upstream

# Switch to main branch
git checkout main

# Merge upstream changes
git merge upstream/main

# Push to your fork
git push origin main
```

### 5. Feature Development Workflow
```bash
# Create feature branch from development
git checkout development
git checkout -b feature/your-feature-name

# Make your changes
# ... code changes ...

# Commit your changes
git add .
git commit -m "feat: add your feature description"

# Push to your fork
git push origin feature/your-feature-name

# Create Pull Request on GitHub
```

## Custom Package Development

### 1. Package Structure
Create custom packages in the `packages/Custom/` directory:

```
packages/
├── Custom/
│   ├── YourPackage/
│   │   ├── src/
│   │   │   ├── Config/
│   │   │   ├── Database/
│   │   │   ├── Http/
│   │   │   ├── Models/
│   │   │   ├── Providers/
│   │   │   └── Resources/
│   │   ├── composer.json
│   │   └── package.json
```

### 2. Package Development Commands
```bash
# Create new package
mkdir -p packages/Custom/YourPackage
cd packages/Custom/YourPackage

# Initialize Composer package
composer init

# Initialize NPM package
npm init -y
```

### 3. Package Registration
Add your package to `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "Custom\\YourPackage\\": "packages/Custom/YourPackage/src/"
        }
    }
}
```

### 4. Service Provider
Create a service provider for your package:

```php
<?php

namespace Custom\YourPackage\Providers;

use Illuminate\Support\ServiceProvider;

class YourPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register your package services
    }

    public function boot()
    {
        // Boot your package
    }
}
```

## Collaboration Workflow

### 1. Team Repository Setup
```bash
# Add team member as collaborator to your fork
# Or create organization repository

# Clone team repository
git clone https://github.com/TEAM_ORG/centurion.git
cd centurion

# Add team repository as origin
git remote add origin https://github.com/TEAM_ORG/centurion.git
```

### 2. Branch Protection
- Protect `main` and `development` branches
- Require pull request reviews
- Require status checks to pass

### 3. Code Review Process
1. Create feature branch
2. Make changes and commit
3. Push to team repository
4. Create Pull Request
5. Request review from team members
6. Address feedback
7. Merge after approval

## Troubleshooting

### Common Issues

#### Vite Build Errors
```bash
# Clear NPM cache
./vendor/bin/sail npm cache clean --force

# Remove node_modules and reinstall
rm -rf node_modules package-lock.json
./vendor/bin/sail npm install
```

#### Database Connection Issues
```bash
# Check if MySQL is running
./vendor/bin/sail ps

# Restart MySQL container
./vendor/bin/sail restart mysql

# Check database configuration
./vendor/bin/sail artisan config:show database
```

#### Permission Issues
```bash
# Fix storage permissions
./vendor/bin/sail artisan storage:link
chmod -R 775 storage bootstrap/cache
```

#### Cache Issues
```bash
# Clear all caches
./vendor/bin/sail artisan optimize:clear
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
```

### Performance Optimization
```bash
# Optimize for production
./vendor/bin/sail artisan optimize
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

### Debug Mode
```bash
# Enable debug mode
./vendor/bin/sail artisan config:set app.debug=true

# Disable debug mode
./vendor/bin/sail artisan config:set app.debug=false
```

## Environment Variables

### Key Configuration
```env
APP_NAME=Centurion
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=Africa/Cairo

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=bagistoDB
DB_USERNAME=bagistoDB_user
DB_PASSWORD=bagistoDB_pass

REDIS_HOST=redis
REDIS_PORT=6379
```

## Useful Aliases

Add these to your shell configuration (`.bashrc`, `.zshrc`):

```bash
# Sail aliases
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
alias sa='sail artisan'
alias sam='sail artisan migrate'
alias samf='sail artisan migrate:fresh --seed'
alias saseed='sail artisan db:seed'
alias sacache='sail artisan cache:clear'
alias saopt='sail artisan optimize'
alias saoptc='sail artisan optimize:clear'
alias saup='sail up -d'
alias sadown='sail down'
alias saps='sail ps'
alias salogs='sail logs'
alias sashell='sail shell'
alias samysql='sail mysql'
alias saredis='sail redis'
```

## Support

- **Documentation**: [Bagisto Docs](https://devdocs.bagisto.com/)
- **GitHub Issues**: [Bagisto Issues](https://github.com/bagisto/bagisto/issues)
- **Community Forum**: [Bagisto Forum](https://forums.bagisto.com/)

---

**Note**: This guide is specifically tailored for Centurion, a customized version of Bagisto. Always refer to the official Bagisto documentation for the most up-to-date information. 