# تشغيل Authentication

## الخطوات

### 1️⃣ تشغيل قاعدة البيانات
```bash
# تأكد أن MySQL يعمل
# على Windows: بدّل MySQL Service
# على Mac/Linux: brew services start mysql أو sudo systemctl start mysql
```

### 2️⃣ تهيئة قاعدة البيانات
```bash
# في مجلد المشروع
php artisan migrate

# أو إذا أردت إعادة تهيئة من الصفر
php artisan migrate:fresh --seed
```

### 3️⃣ إنشاء مستخدم تجريبي
```bash
php artisan tinker
> \App\Models\User::create(['name' => 'Admin User', 'email' => 'admin@test.com', 'password' => \Illuminate\Support\Facades\Hash::make('password123'), 'role' => 'admin'])
> exit
```

### 4️⃣ تشغيل الخادم
```bash
php artisan serve
# الآن الموقع يعمل على: http://127.0.0.1:8000
```

### 5️⃣ الدخول
```
الرابط: http://127.0.0.1:8000/login
البريد: admin@test.com
كلمة المرور: password123
```

---

## ما تم تنفيذه

✅ **LoginController**
- showLoginForm() - عرض صفحة اللوغين
- login() - معالجة طلب اللوغين مع التحقق
- logout() - تسجيل الخروج

✅ **RegisterController**
- showRegisterForm() - عرض صفحة التسجيل
- register() - معالجة التسجيل الجديد

✅ **Auth Routes**
```
GET  /login   → عرض الصفحة
POST /login   → معالجة اللوغين
GET  /register   → عرض الصفحة
POST /register   → معالجة التسجيل
POST /logout  → تسجيل الخروج
```

✅ **Validation**
- Email: required, valid email
- Password: required, min 6 (login) / min 8 (register)
- Name: required
- Role: required, one of [user, researcher, admin]
- Password Confirmation: for register

✅ **Activity Logging**
- تسجيل اللوغين في ActivityLog

---

## ملاحظات

1. استخدم `Remember me` لإبقاء جلسة طويلة
2. الجلسات مخزنة في Database (SESSION_DRIVER=database)
3. كلمات المرور مشفرة بـ Bcrypt

---

## اختبار سريع

```bash
# 1. إنشاء مستخدم
php artisan tinker
>>> \App\Models\User::factory()->create(['email' => 'test@test.com'])

# 2. محاولة اللوغين
# المتصفح: http://127.0.0.1:8000/login
# البريد: test@test.com
# كلمة المرور: password (من الـ factory)
```

---

**الحالة: Authentication نظام كامل** ✅
