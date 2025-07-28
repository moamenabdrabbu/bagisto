# Centurion Quick Reference Guide

## 🚀 Quick Start Commands

```bash
# Start all services
./vendor/bin/sail up -d

# Stop all services
./vendor/bin/sail down

# View running containers
./vendor/bin/sail ps
```

## 📝 Daily Development Commands

### Database
```bash
# Run migrations
./vendor/bin/sail artisan migrate

# Reset database (fresh + seed)
./vendor/bin/sail artisan migrate:fresh --seed

# Seed database
./vendor/bin/sail artisan db:seed
```

### Cache Management
```bash
# Clear all caches
./vendor/bin/sail artisan optimize:clear

# Optimize for production
./vendor/bin/sail artisan optimize
```

### Frontend
```bash
# Run development server
./vendor/bin/sail npm run dev

# Build for production
./vendor/bin/sail npm run build
```

### Testing
```bash
# Run tests
./vendor/bin/sail test

# Run tests with coverage
./vendor/bin/sail test --coverage
```

## 🔧 Troubleshooting

### Common Issues
```bash
# Vite build errors
./vendor/bin/sail npm cache clean --force
rm -rf node_modules package-lock.json
./vendor/bin/sail npm install

# Database connection
./vendor/bin/sail restart mysql

# Permission issues
chmod -R 775 storage bootstrap/cache
```

## 🌐 Access URLs

- **Main App**: http://localhost
- **Admin Panel**: http://localhost/admin
- **Email Testing**: http://localhost:8025
- **Kibana**: http://localhost:5601

## 🔑 Default Credentials

- **Email**: `admin@example.com`
- **Password**: `admin123`

## 📦 Package Management

```bash
# Install Composer package
./vendor/bin/sail composer require package-name

# Install NPM package
./vendor/bin/sail npm install package-name

# Update dependencies
./vendor/bin/sail composer update
./vendor/bin/sail npm update
```

## 🐳 Container Access

```bash
# Shell access
./vendor/bin/sail shell

# MySQL access
./vendor/bin/sail mysql

# Redis access
./vendor/bin/sail redis

# View logs
./vendor/bin/sail logs
```

## 🔄 Git Workflow

```bash
# Create feature branch
git checkout -b feature/your-feature

# Commit changes
git add .
git commit -m "feat: your feature description"

# Push to remote
git push origin feature/your-feature
```

## 📋 Useful Aliases

Add to your `.bashrc` or `.zshrc`:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
alias sa='sail artisan'
alias saup='sail up -d'
alias sadown='sail down'
alias saps='sail ps'
alias salogs='sail logs'
alias sashell='sail shell'
alias samysql='sail mysql'
alias saredis='sail redis'
alias sam='sail artisan migrate'
alias samf='sail artisan migrate:fresh --seed'
alias sacache='sail artisan cache:clear'
alias saopt='sail artisan optimize'
alias saoptc='sail artisan optimize:clear'
``` 