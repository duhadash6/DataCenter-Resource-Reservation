@echo off
REM ============================================
REM Data Center Reservation - Quick Setup
REM ============================================

echo.
echo 🔧 Data Center Reservation - Setup Script
echo ==========================================
echo.

REM 1. التحقق من وجود Composer و PHP
echo ✓ Checking PHP and Composer...
php -v > nul 2>&1 && (
    echo   PHP: OK
) || (
    echo   PHP: FAILED - Please install PHP
    pause
    exit /b 1
)

composer --version > nul 2>&1 && (
    echo   Composer: OK
) || (
    echo   Composer: FAILED - Please install Composer
    pause
    exit /b 1
)

REM 2. تثبيت Dependencies
echo.
echo 📦 Installing dependencies...
composer install

REM 3. إنشاء .env إذا لم يكن موجوداً
echo.
echo ⚙️  Configuring environment...
if not exist .env (
    if exist .env.example (
        copy .env.example .env
    ) else (
        echo ERROR: .env.example not found
        pause
        exit /b 1
    )
)

REM 4. توليد APP_KEY
echo 🔐 Generating application key...
php artisan key:generate

REM 5. تشغيل Migrations
echo.
echo 🗄️  Running migrations...
php artisan migrate --force

REM 6. إنشاء مستخدمي اختبار
echo.
echo 👥 Creating test users...

php artisan tinker --execute="^
$admin = App\Models\User::create(['name' => 'Admin User', 'email' => 'admin@test.com', 'password' => \Illuminate\Support\Facades\Hash::make('password123'), 'role' => 'admin']); ^
echo 'Created: ' . $admin->email . ' (Role: ' . $admin->role . ')' . PHP_EOL; ^
$manager = App\Models\User::create(['name' => 'Manager User', 'email' => 'manager@test.com', 'password' => \Illuminate\Support\Facades\Hash::make('password123'), 'role' => 'manager']); ^
echo 'Created: ' . $manager->email . ' (Role: ' . $manager->role . ')' . PHP_EOL; ^
$user = App\Models\User::create(['name' => 'Regular User', 'email' => 'user@test.com', 'password' => \Illuminate\Support\Facades\Hash::make('password123'), 'role' => 'user']); ^
echo 'Created: ' . $user->email . ' (Role: ' . $user->role . ')' . PHP_EOL; ^
"

echo.
echo ✅ Setup Complete!
echo.
echo 📝 Test Credentials:
echo    Admin:   admin@test.com / password123
echo    Manager: manager@test.com / password123
echo    User:    user@test.com / password123
echo.
echo 🚀 To start the server:
echo    php artisan serve
echo.
echo 🌐 Then visit:
echo    http://127.0.0.1:8000/login
echo.
pause
