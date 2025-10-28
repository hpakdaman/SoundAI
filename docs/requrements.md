
Admin Panel: Filament v3 (لایسنس MIT) ✅
Authentication & Social Login: Laravel Breeze/Jetstream + Socialite (MIT)
Payment & Subscription: Laravel Cashier برای Stripe/Paddle (MIT)

Essential Packages:
// همه با لایسنس MIT
spatie/laravel-medialibrary    // مدیریت فایل‌ها
spatie/laravel-translatable    // چندزبانه
spatie/laravel-sitemap         // Sitemap
spatie/laravel-backup          // بکاپ
spatie/laravel-activitylog     // لاگ فعالیت‌ها
```

### Auth and permission
https://filamentphp.com/plugins/hexters-hexa

### **🎨 Frontend:**
- **Tailwind CSS **
- **Alpine.js **
- **Livewire **

### **🎨 Admin:**
- **Filament **

### **💳 Payment Gateways:**
- **Stripe** (اصلی)
- **PayPal** 

### **🚀 ساختار پوشه‌ها:**
```
app/
├── Filament/          # Admin Panel
│   ├── Resources/
│   ├── Widgets/
│   └── Pages/
├── Models/
├── Services/          # Business Logic
│   ├── PaymentService
│   └── AIVoiceService
└── Http/
    └── Controllers/ 