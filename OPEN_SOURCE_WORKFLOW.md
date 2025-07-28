# Open Source Workflow & Custom Package Development Guide

## 🎯 Goals

This guide helps you:
1. **Keep the base Bagisto code clean** for easy upgrades
2. **Develop custom packages** without modifying core files
3. **Collaborate effectively** with your development team
4. **Maintain proper Git workflow** for open-source projects

## 📋 Prerequisites

- GitHub account
- Git installed locally
- Basic understanding of Git commands
- Docker setup (as per installation guide)

## 🔄 Open Source Workflow

### Step 1: Fork the Repository

1. **Go to Bagisto Repository**
   - Visit: https://github.com/bagisto/bagisto
   - Click the "Fork" button in the top right corner
   - This creates your own copy of the repository

2. **Clone Your Fork**
   ```bash
   # Clone your forked repository
   git clone https://github.com/moamenabdrabbu/bagisto centurion
   cd centurion
   
   # Add the original repository as upstream
   git remote add upstream https://github.com/bagisto/bagisto.git
   ```

3. **Verify Remotes**
   ```bash
   git remote -v
   # Should show:
   # origin    https://github.com/YOUR_USERNAME/bagisto.git (fetch)
   # origin    https://github.com/YOUR_USERNAME/bagisto.git (push)
   # upstream  https://github.com/bagisto/bagisto.git (fetch)
   # upstream  https://github.com/bagisto/bagisto.git (push)
   ```

### Step 2: Create Development Branch

```bash
# Create and switch to development branch
git checkout -b development

# Push development branch to your fork
git push -u origin development
```

### Step 3: Keep Your Fork Updated

```bash
# Fetch latest changes from upstream
git fetch upstream

# Switch to main branch
git checkout main

# Merge upstream changes
git merge upstream/main

# Push to your fork
git push origin main

# Update development branch
git checkout development
git merge main
git push origin development
```

### Step 4: Feature Development Workflow

```bash
# Create feature branch from development
git checkout development
git checkout -b feature/your-feature-name

# Make your changes
# ... code changes ...

# Commit your changes with conventional commits
git add .
git commit -m "feat: add custom payment gateway integration"

# Push to your fork
git push origin feature/your-feature-name

# Create Pull Request on GitHub
# Go to: https://github.com/YOUR_USERNAME/bagisto/pulls
```

## 📦 Custom Package Development

### Package Structure

Create custom packages in the `packages/Custom/` directory:

```
packages/
├── Custom/
│   ├── PaymentGateway/
│   │   ├── src/
│   │   │   ├── Config/
│   │   │   │   └── payment-gateway.php
│   │   │   ├── Database/
│   │   │   │   ├── Migrations/
│   │   │   │   └── Seeders/
│   │   │   ├── Http/
│   │   │   │   ├── Controllers/
│   │   │   │   ├── Middleware/
│   │   │   │   └── Requests/
│   │   │   ├── Models/
│   │   │   ├── Providers/
│   │   │   │   └── PaymentGatewayServiceProvider.php
│   │   │   ├── Resources/
│   │   │   │   ├── assets/
│   │   │   │   ├── lang/
│   │   │   │   └── views/
│   │   │   └── Routes/
│   │   │       └── web.php
│   │   ├── composer.json
│   │   ├── package.json
│   │   └── README.md
│   └── AnotherPackage/
```

### Creating a New Package

#### 1. Create Package Directory
```bash
# Create package directory
mkdir -p packages/Custom/YourPackage
cd packages/Custom/YourPackage

# Initialize Composer package
composer init \
  --name="custom/your-package" \
  --description="Your custom package description" \
  --author="Your Name <your.email@example.com>" \
  --type="library" \
  --require="php:^8.1" \
  --require="laravel/framework:^11.0" \
  --autoload="psr-4" \
  --autoload-src="Custom\\YourPackage\\:src/" \
  --no-interaction

# Initialize NPM package (if needed)
npm init -y
```

#### 2. Package Composer Configuration
```json
{
    "name": "custom/your-package",
    "description": "Your custom package description",
    "type": "library",
    "license": "MIT",
    "authors": [
        {
            "name": "Your Name",
            "email": "your.email@example.com"
        }
    ],
    "require": {
        "php": "^8.1",
        "laravel/framework": "^11.0"
    },
    "autoload": {
        "psr-4": {
            "Custom\\YourPackage\\": "src/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Custom\\YourPackage\\Providers\\YourPackageServiceProvider"
            ]
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

#### 3. Service Provider
```php
<?php

namespace Custom\YourPackage\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class YourPackageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register your package services
        $this->mergeConfigFrom(
            __DIR__.'/../Config/your-package.php', 'your-package'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        
        // Load views
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'your-package');
        
        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        
        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'your-package');
        
        // Publish assets
        $this->publishes([
            __DIR__.'/../Config/your-package.php' => config_path('your-package.php'),
            __DIR__.'/../Resources/views' => resource_path('views/vendor/your-package'),
            __DIR__.'/../Resources/lang' => lang_path('vendor/your-package'),
        ], 'your-package');
    }
}
```

#### 4. Register Package in Main Application

Add to your main `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Custom\\YourPackage\\": "packages/Custom/YourPackage/src/"
        }
    }
}
```

#### 5. Register Service Provider

Add to `config/app.php`:

```php
'providers' => [
    // ... other providers
    Custom\YourPackage\Providers\YourPackageServiceProvider::class,
],
```

### Package Development Commands

```bash
# Create new package
mkdir -p packages/Custom/YourPackage
cd packages/Custom/YourPackage

# Initialize package
composer init
npm init -y

# Install dependencies
composer install
npm install

# Build assets (if needed)
npm run build

# Test package
./vendor/bin/sail test packages/Custom/YourPackage/tests/
```

## 👥 Team Collaboration

### Option 1: Organization Repository

1. **Create GitHub Organization**
   - Go to GitHub → Settings → Organizations
   - Create new organization (e.g., "YourCompany")

2. **Create Organization Repository**
   ```bash
   # Clone organization repository
   git clone https://github.com/YourCompany/centurion.git
   cd centurion
   
   # Add your fork as upstream
   git remote add upstream https://github.com/YOUR_USERNAME/bagisto.git
   ```

3. **Team Workflow**
   ```bash
   # Create feature branch
   git checkout -b feature/team-feature
   
   # Make changes
   # ... code changes ...
   
   # Commit and push
   git add .
   git commit -m "feat: team feature implementation"
   git push origin feature/team-feature
   
   # Create Pull Request to organization repository
   ```

### Option 2: Fork Collaboration

1. **Add Team Members as Collaborators**
   - Go to your fork settings
   - Add team members as collaborators

2. **Team Workflow**
   ```bash
   # Clone your fork
   git clone https://github.com/YOUR_USERNAME/bagisto.git
   cd bagisto
   
   # Create feature branch
   git checkout -b feature/team-feature
   
   # Make changes and push
   git push origin feature/team-feature
   ```

### Branch Protection Rules

Set up branch protection for `main` and `development`:

1. Go to repository settings
2. Branches → Add rule
3. Configure:
   - Require pull request reviews
   - Require status checks to pass
   - Require branches to be up to date
   - Restrict pushes to matching branches

## 🔄 Git Best Practices

### Conventional Commits

Use conventional commit format:

```bash
# Feature
git commit -m "feat: add custom payment gateway"

# Bug fix
git commit -m "fix: resolve payment processing error"

# Documentation
git commit -m "docs: update installation guide"

# Refactor
git commit -m "refactor: improve payment validation"

# Test
git commit -m "test: add payment gateway tests"
```

### Branch Naming

```bash
# Feature branches
git checkout -b feature/payment-gateway
git checkout -b feature/user-authentication

# Bug fix branches
git checkout -b fix/payment-error
git checkout -b fix/login-issue

# Hotfix branches
git checkout -b hotfix/security-patch
```

### Pull Request Template

Create `.github/pull_request_template.md`:

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests pass
- [ ] Integration tests pass
- [ ] Manual testing completed

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes
```

## 🚀 Deployment Strategy

### Development Environment
```bash
# Use Docker for development
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:fresh --seed
```

### Staging Environment
```bash
# Deploy to staging
git checkout staging
git merge development
# Deploy to staging server
```

### Production Environment
```bash
# Deploy to production
git checkout main
git merge staging
# Deploy to production server
```

## 📚 Resources

- [GitHub Flow](https://guides.github.com/introduction/flow/)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [Laravel Package Development](https://laravel.com/docs/packages)
- [Bagisto Documentation](https://devdocs.bagisto.com/)

## 🎯 Next Steps

1. **Fork the repository** following the steps above
2. **Create your development branch**
3. **Set up your first custom package**
4. **Invite your team members**
5. **Start developing features**

Remember: Always keep the base Bagisto code clean and separate your customizations into packages! 