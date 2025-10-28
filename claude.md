## Project Architecture

This is a **self-hosted CMS platform** (similar to WordPress) that users can install on their own servers/hosting.

### Framework Usage Guidelines
- **Frontend (Public-facing website)**: Use **Livewire 3.x** + **Alpine.js 3.x** only
- **Admin Panel**: Use **Filament 4.x** exclusively
- **Styling**: Tailwind CSS 4.x for both frontend and admin

### Deployment Model
- Users download/purchase the complete package (including vendor folder)
- Upload all files to their hosting/web server and run installation wizard
- System works immediately (assuming server meets requirements)

### Server Requirements
- PHP 8.2+
- MySQL/MariaDB or PostgreSQL
- Composer installed (for initial setup)
- Standard LAMP/LEMP stack capabilities

## Framework Documentation
Use these version-specific documentation links based on current project dependencies:

### Backend (PHP/Laravel)
- **Laravel 12.x**: https://laravel.com/docs/12.x
- **Filament 4.x**: https://filamentphp.com/docs/4.x/panels/installation
- **Livewire 3.x**: https://livewire.laravel.com/docs/3.x/quickstart (included with Filament 4.x)

### Frontend
- **Tailwind CSS 4.x**: https://tailwindcss.com/docs/v4/installation
- **Alpine.js 3.x**: https://alpinejs.dev/start-here (included with Livewire/Filament)

### Additional Packages
- **Filament Language Switch 4.x**: https://github.com/bezhansalleh/filament-language-switch
- **Filament Blog 3.x**: https://github.com/firefly/filament-blog