# Project Structure & Architecture

## Overview
This is a **self-hosted CMS platform** designed for multi-purpose use across all company projects. Users can install it on their own servers (similar to WordPress).

---

## Directory Structure

```
laravel-ai-music-composer/
├── app/
│   ├── Console/
│   │   └── Commands/           # Custom Artisan commands, cron jobs
│   ├── Exceptions/
│   ├── Filament/
│   │   ├── Resources/          # Filament admin resources
│   │   ├── Pages/              # Custom admin pages
│   │   ├── Widgets/            # Dashboard widgets
│   │   └── Clusters/           # Resource grouping
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/       # Public website controllers
│   │   │   └── Api/            # API endpoints
│   │   ├── Livewire/           # Livewire components (frontend only)
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Services/               # Business logic layer
│   │   ├── Payment/
│   │   ├── Subscription/
│   │   ├── Notification/
│   │   └── Analytics/
│   ├── Repositories/           # Data access layer
│   ├── Jobs/                   # Queue jobs
│   ├── Events/
│   ├── Listeners/
│   ├── Mail/                   # Emails
│   ├── Notifications/
│   ├── Policies/               # Authorization policies
│   └── Providers/
├── bootstrap/
├── config/
│   ├── filament.php
│   ├── payment-gateways.php
│   ├── social-providers.php
│   └── cms.php                 # Core CMS configuration
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── public/
│   ├── assets/
│   │   ├── frontend/           # Public website assets
│   │   └── uploads/            # User uploads
│   ├── installer/              # Installation wizard files
│   └── index.php
├── resources/
│   ├── views/
│   │   ├── livewire/           # Livewire frontend components
│   │   ├── layouts/
│   │   │   └── app.blade.php   # Frontend layout
│   │   ├── frontend/           # Public pages
│   │   ├── emails/             # Email templates
│   │   └── installer/          # Installation wizard views
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                 # Frontend routes
│   ├── api.php
│   └── console.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   ├── backups/
│   │   └── logs/
│   ├── framework/
│   └── logs/
├── tests/
├── vendor/                     # Included in distribution package
├── docs/
├── .env.example
└── installer.php               # Installation entry point
```

---

## Module Organization

### Core Modules

#### 1. **Authentication & Authorization**
- `app/Models/User.php`
- `app/Policies/`
- `app/Filament/Resources/UserResource.php`
- `app/Filament/Resources/RoleResource.php`
- `app/Filament/Resources/PermissionResource.php`

#### 2. **Payment System**
- `app/Services/Payment/PaymentGatewayService.php`
- `app/Models/Payment.php`
- `app/Models/Transaction.php`
- `app/Models/PaymentGateway.php`
- `app/Filament/Resources/PaymentResource.php`
- `app/Filament/Resources/TransactionResource.php`

#### 3. **Subscription Management**
- `app/Models/Plan.php`
- `app/Models/Subscription.php`
- `app/Models/SubscriptionUsage.php`
- `app/Services/Subscription/SubscriptionService.php`
- `app/Filament/Resources/PlanResource.php`
- `app/Filament/Resources/SubscriptionResource.php`

#### 4. **Support System**
- `app/Models/Ticket.php`
- `app/Models/TicketMessage.php`
- `app/Models/TicketCategory.php`
- `app/Filament/Resources/TicketResource.php`
- `app/Http/Livewire/TicketSystem.php` (Frontend)

#### 5. **Content Management**
- `app/Models/Page.php`
- `app/Models/Post.php` (Blog)
- `app/Models/Category.php`
- `app/Models/Tag.php`
- `app/Filament/Resources/PageResource.php`
- `app/Http/Livewire/PageBuilder.php`

#### 6. **Multi-Language**
- `app/Models/Language.php`
- `app/Models/Translation.php`
- `app/Services/Translation/TranslationService.php`
- `app/Filament/Resources/LanguageResource.php`

#### 7. **Email Management**
- `app/Models/EmailTemplate.php`
- `app/Services/Email/EmailService.php`
- `app/Filament/Resources/EmailTemplateResource.php`

#### 8. **FAQ System**
- `app/Models/Faq.php`
- `app/Models/FaqCategory.php`
- `app/Filament/Resources/FaqResource.php`

#### 9. **Live Chat**
- `app/Models/ChatConversation.php`
- `app/Models/ChatMessage.php`
- `app/Http/Livewire/LiveChat.php`
- `app/Filament/Resources/ChatResource.php`

#### 10. **Analytics & Reporting**
- `app/Services/Analytics/AnalyticsService.php`
- `app/Filament/Widgets/AnalyticsDashboard.php`
- `app/Models/AnalyticsEvent.php`

#### 11. **SEO & Marketing**
- `app/Models/SeoMeta.php`
- `app/Services/Seo/SitemapGenerator.php`
- `app/Services/Seo/RobotsTxtGenerator.php`
- `app/Models/TrackingSnippet.php`
- `app/Filament/Resources/SeoResource.php`

#### 12. **Advertisement Management**
- `app/Models/Advertisement.php`
- `app/Models/AdPlacement.php`
- `app/Filament/Resources/AdvertisementResource.php`

#### 13. **System Configuration**
- `app/Models/Setting.php`
- `app/Services/Config/ConfigService.php`
- `app/Filament/Pages/Settings.php`

#### 14. **Branding**
- `app/Models/Branding.php`
- `app/Filament/Resources/BrandingResource.php`

#### 15. **Cron & Automation**
- `app/Console/Kernel.php`
- `app/Console/Commands/`
- `app/Filament/Resources/CronJobResource.php`

#### 16. **Maintenance Mode**
- `app/Http/Middleware/MaintenanceMode.php`
- `app/Filament/Pages/MaintenanceControl.php`

#### 17. **Security Suite**
- `app/Services/Security/FirewallService.php`
- `app/Models/BlockedIp.php`
- `app/Models/SecurityLog.php`
- `app/Filament/Resources/SecurityResource.php`

---

## Installation System

### Installer Flow
1. **Pre-Installation Check** (`installer/check.php`)
   - PHP version check
   - Required extensions
   - Directory permissions
   - Database connection test

2. **Database Setup** (`installer/database.php`)
   - Create `.env` file
   - Database credentials
   - Run migrations
   - Seed initial data

3. **Admin Account** (`installer/admin.php`)
   - Create super admin
   - Set site details

4. **Finalization** (`installer/finish.php`)
   - Generate APP_KEY
   - Clear caches
   - Remove installer files (optional)
   - Redirect to admin panel

---

## Database Schema Overview

### Core Tables
- `users` - User accounts
- `roles` - User roles
- `permissions` - System permissions
- `role_user` - Role assignments
- `permission_role` - Permission assignments

### Payment Tables
- `payments` - Payment records
- `transactions` - Transaction history
- `payment_gateways` - Gateway configurations
- `refunds` - Refund records

### Subscription Tables
- `plans` - Subscription plans
- `subscriptions` - User subscriptions
- `subscription_usage` - Usage tracking
- `subscription_history` - Subscription changes

### Support Tables
- `tickets` - Support tickets
- `ticket_messages` - Ticket conversations
- `ticket_categories` - Ticket categories

### Content Tables
- `pages` - Static pages
- `posts` - Blog posts
- `categories` - Content categories
- `tags` - Content tags
- `media` - Media library

### System Tables
- `settings` - System configuration
- `languages` - Available languages
- `translations` - Translation strings
- `email_templates` - Email templates
- `faqs` - FAQ entries
- `chat_conversations` - Chat sessions
- `chat_messages` - Chat messages
- `analytics_events` - Analytics data
- `seo_meta` - SEO metadata
- `tracking_snippets` - Tracking codes
- `advertisements` - Ad management
- `cron_jobs` - Scheduled tasks
- `security_logs` - Security events
- `blocked_ips` - IP blocklist

---

## Frontend Architecture

### Livewire Components (Public Website)
```
resources/views/livewire/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── social-login.blade.php
├── user/
│   ├── profile.blade.php
│   ├── subscription.blade.php
│   └── billing-history.blade.php
├── support/
│   ├── ticket-list.blade.php
│   ├── ticket-create.blade.php
│   └── ticket-view.blade.php
├── blog/
│   ├── post-list.blade.php
│   └── post-view.blade.php
├── chat/
│   └── live-chat-widget.blade.php
└── pages/
    └── dynamic-page.blade.php
```

### Alpine.js Usage
- Form validation
- Modal interactions
- Dropdown menus
- Dynamic UI states
- Smooth transitions

---

## Admin Panel Architecture (Filament)

### Resource Organization
```
app/Filament/
├── Resources/
│   ├── User/
│   │   ├── UserResource.php
│   │   └── Pages/
│   ├── Payment/
│   │   ├── PaymentResource.php
│   │   ├── TransactionResource.php
│   │   └── PaymentGatewayResource.php
│   ├── Subscription/
│   │   ├── PlanResource.php
│   │   └── SubscriptionResource.php
│   ├── Content/
│   │   ├── PageResource.php
│   │   ├── PostResource.php
│   │   └── MediaResource.php
│   └── System/
│       ├── SettingResource.php
│       ├── LanguageResource.php
│       └── EmailTemplateResource.php
├── Pages/
│   ├── Dashboard.php
│   ├── Settings.php
│   ├── Analytics.php
│   └── MaintenanceMode.php
└── Widgets/
    ├── StatsOverview.php
    ├── RevenueChart.php
    ├── UserGrowthChart.php
    └── LatestTickets.php
```

---

## API Structure (Optional)

```
routes/api.php

v1/
├── auth/
│   ├── POST /login
│   ├── POST /register
│   └── POST /logout
├── payments/
│   ├── GET /gateways
│   └── POST /process
├── subscriptions/
│   ├── GET /plans
│   └── POST /subscribe
├── tickets/
│   ├── GET /tickets
│   └── POST /tickets
└── user/
    ├── GET /profile
    └── PUT /profile
```

---

## Key Services

### PaymentGatewayService
Handles 30+ payment providers:
- Stripe
- PayPal
- Razorpay
- Mollie
- Paddle
- (and more...)

### SubscriptionService
- Plan management
- Usage tracking
- Automated billing
- Upgrade/downgrade logic

### NotificationService
- Email notifications
- SMS (optional)
- In-app notifications
- Real-time alerts

### AnalyticsService
- User tracking
- Revenue reports
- Conversion metrics
- Custom events

### SEO Service
- Dynamic sitemap generation
- robots.txt management
- Meta tag injection
- Structured data (JSON-LD)

---

## Deployment Checklist

### Pre-Deployment
- [ ] Build vendor folder (`composer install --no-dev`)
- [ ] Compile assets (`npm run build`)
- [ ] Optimize autoloader (`composer dump-autoload --optimize`)
- [ ] Create `.env.example` with all variables
- [ ] Include installer files
- [ ] Create documentation

### Distribution Package
```
release-package/
├── all-project-files/
├── vendor/               # Pre-installed
├── node_modules/         # Optional (if needed)
├── public/build/         # Compiled assets
├── installer/            # Installation wizard
├── .env.example
├── README.md
└── INSTALLATION.md
```

### Server Requirements
- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 10+
- Apache/Nginx
- SSL certificate (recommended)
- 512MB RAM minimum
- File upload permissions

---

## Security Features

1. **CSRF Protection** (Laravel default)
2. **XSS Prevention** (Blade escaping)
3. **SQL Injection Protection** (Eloquent ORM)
4. **Rate Limiting**
5. **IP Blocking**
6. **Two-Factor Authentication** (optional)
7. **Activity Logging**
8. **File Upload Validation**
9. **Password Encryption** (bcrypt)
10. **Security Headers**

---

## Performance Optimization

1. **Caching Strategy**
   - Redis/Memcached support
   - Query caching
   - View caching
   - Route caching

2. **Database Optimization**
   - Proper indexing
   - Eager loading
   - Query optimization

3. **Asset Optimization**
   - Minified CSS/JS
   - Image optimization
   - CDN support

4. **Queue System**
   - Background jobs
   - Email queuing
   - Report generation

---

## Backup & Recovery

1. **Automated Backups**
   - Database backups
   - File backups
   - Scheduled backups

2. **Restore Functionality**
   - One-click restore
   - Backup management
   - Download backups
