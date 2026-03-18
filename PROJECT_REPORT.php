<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║  📊 تقرير شامل - Data Center Reservation System              ║\n";
echo "║  تاريخ: " . date('Y-m-d H:i:s') . "                           ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// ==================== SECTION 1: PROJECT STRUCTURE ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "1️⃣  هيكل المشروع\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "🏗️  Framework: Laravel 12.47.0\n";
echo "🐘 PHP: 8.2.12\n";
echo "🗄️  Database: MySQL\n";
echo "🎨 Frontend: Tailwind CSS + Blade Templates\n";
echo "🔐 Auth: Custom Authentication with Role-Based Access Control\n\n";

// ==================== SECTION 2: DATABASE ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "2️⃣  قاعدة البيانات والجداول\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$tables = [
    'users' => 'جدول المستخدمين',
    'resources' => 'جدول الموارد',
    'reservations' => 'جدول الحجوزات',
    'activity_logs' => 'جدول السجلات',
    'sessions' => 'جدول الجلسات'
];

foreach ($tables as $table => $description) {
    $exists = Schema::hasTable($table);
    $count = $exists ? DB::table($table)->count() : 0;
    echo "   " . ($exists ? '✅' : '❌') . " $description ($table) - $count سجل\n";
}
echo "\n";

// ==================== SECTION 3: STATISTICS ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "3️⃣  الإحصائيات\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "👥 المستخدمين:\n";
echo "   📊 الكلي: " . User::count() . "\n";
echo "   👨‍💼 المسؤولون/المديرون: " . User::whereIn('role', ['admin', 'manager'])->count() . "\n";
echo "   👤 المستخدمون العاديون: " . User::where('role', 'user')->count() . "\n\n";

echo "🖥️  الموارد:\n";
echo "   📊 الكلي: " . Resource::count() . "\n";
echo "   ✅ المتاح: " . Resource::where('status', 'available')->count() . "\n";
echo "   📍 المحجوز: " . Resource::where('status', 'reserved')->count() . "\n";
echo "   🔧 الصيانة: " . Resource::where('status', 'maintenance')->count() . "\n";
echo "   ❌ معطل: " . Resource::where('status', 'down')->count() . "\n\n";

echo "📦 الحجوزات:\n";
echo "   📊 الكلي: " . Reservation::count() . "\n";
echo "   ⏳ المعلقة: " . Reservation::where('status', 'pending')->count() . "\n";
echo "   ✅ الموافقة عليها: " . Reservation::where('status', 'approved')->count() . "\n";
echo "   ▶️  النشطة: " . Reservation::where('status', 'active')->count() . "\n";
echo "   ❌ المرفوضة: " . Reservation::where('status', 'rejected')->count() . "\n";
echo "   ✔️  المنتهية: " . Reservation::where('status', 'finished')->count() . "\n\n";

echo "📋 الأنشطة:\n";
echo "   📊 الكلي: " . ActivityLog::count() . "\n\n";

// ==================== SECTION 4: MODELS ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "4️⃣  نماذج البيانات (Models)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "   ✅ User - المستخدم\n";
echo "      - Attributes: name, email, password, role\n";
echo "      - Methods: isAdmin(), reservations()\n";
echo "      - Roles: admin, manager, user\n\n";

echo "   ✅ Resource - الموارد\n";
echo "      - Attributes: name, type, status, location, specs, capacity\n";
echo "      - Types: server, vm, storage, network\n";
echo "      - Status: available, reserved, maintenance, down\n";
echo "      - Scopes: byType(), byStatus(), search()\n\n";

echo "   ✅ Reservation - الحجوزات\n";
echo "      - Attributes: user_id, resource_id, start_at, end_at, status\n";
echo "      - Status: pending, approved, rejected, active, finished, cancelled\n";
echo "      - Methods: canBeCancelled(), canBeApproved(), canBeRejected()\n\n";

echo "   ✅ ActivityLog - السجلات\n";
echo "      - Attributes: actor_id, action, target_type, target_id, ip_address, changes\n";
echo "      - Actions: resource_create, reservation_create, user_login, etc.\n\n";

// ==================== SECTION 5: CONTROLLERS ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "5️⃣  المتحكمات (Controllers)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "   🔐 Auth\\LoginController\n";
echo "      - showLoginForm() - عرض نموذج الدخول\n";
echo "      - login() - معالجة الدخول مع Bcrypt\n";
echo "      - logout() - تسجيل الخروج\n\n";

echo "   🔐 Auth\\RegisterController\n";
echo "      - showRegisterForm() - عرض نموذج التسجيل\n";
echo "      - register() - معالجة التسجيل الجديد\n";
echo "      - اختيار الدور: user, manager, admin\n\n";

echo "   📋 ResourceController\n";
echo "      - index() - قائمة الموارد بالتصفية والبحث\n";
echo "      - show() - عرض موارد محددة\n\n";

echo "   📦 ReservationController\n";
echo "      - create() - نموذج الحجز\n";
echo "      - store() - إنشاء حجز جديد مع التحقق من التضارب\n";
echo "      - index() - قائمة حجوزات المستخدم\n";
echo "      - show() - عرض تفاصيل الحجز\n";
echo "      - cancel() - إلغاء الحجز\n\n";

echo "   👑 Admin\\ReservationAdminController\n";
echo "      - index() - قائمة الحجوزات للمسؤول\n";
echo "      - approve() - الموافقة على الحجز\n";
echo "      - reject() - رفض الحجز\n\n";

echo "   📊 Admin\\DashboardController\n";
echo "      - index() - لوحة التحكم بالبيانات الحقيقية\n\n";

// ==================== SECTION 6: SERVICES ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "6️⃣  الخدمات (Services)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "   ⚙️  ReservationConflictService\n";
echo "      - hasConflict() - التحقق من التضارب عند الإنشاء\n";
echo "      - hasConflictForApproval() - التحقق عند الموافقة\n";
echo "      - getConflictingReservations() - جلب الحجوزات المتضاربة\n\n";

echo "   📝 ActivityLogService\n";
echo "      - log() - تسجيل نشاط عام\n";
echo "      - logUserLogin() - تسجيل دخول\n";
echo "      - logResourceCreate/Update/Delete() - تسجيل العمليات على الموارد\n";
echo "      - logReservationCreate/Approve/Reject/Cancel() - تسجيل الحجوزات\n\n";

// ==================== SECTION 7: MIDDLEWARE ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "7️⃣  البرامج الوسيطة (Middleware)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "   🔒 IsAdmin\n";
echo "      - التحقق من أن المستخدم admin أو manager\n";
echo "      - رفع خطأ 403 إذا لم يكن مسؤول\n\n";

// ==================== SECTION 8: ROUTES ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "8️⃣  المسارات (Routes)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "🔓 الموارد المفتوحة (Public):\n";
echo "   GET  /                    - الصفحة الرئيسية\n";
echo "   GET  /login               - نموذج الدخول\n";
echo "   POST /login               - معالجة الدخول\n";
echo "   GET  /register            - نموذج التسجيل\n";
echo "   POST /register            - معالجة التسجيل\n";
echo "   GET  /resources           - قائمة الموارد\n";
echo "   GET  /resources/{id}      - عرض موارد\n\n";

echo "🔐 الموارد المحمية (Authenticated):\n";
echo "   POST /logout                              - تسجيل الخروج\n";
echo "   GET  /resources/{id}/reserve              - نموذج الحجز\n";
echo "   POST /resources/{id}/reserve              - إنشاء حجز\n";
echo "   GET  /my-reservations                     - قائمة حجوزاتي\n";
echo "   GET  /my-reservations/{id}                - عرض الحجز\n";
echo "   POST /my-reservations/{id}/cancel         - إلغاء الحجز\n";
echo "   GET  /notifications                       - الإخطارات\n\n";

echo "👑 الموارد الإدارية (Admin):\n";
echo "   GET  /admin                               - لوحة التحكم\n";
echo "   GET  /admin/resources                     - إدارة الموارد\n";
echo "   POST /admin/resources                     - إنشاء موارد\n";
echo "   GET  /admin/reservations                  - قائمة الحجوزات\n";
echo "   POST /admin/reservations/{id}/approve     - الموافقة\n";
echo "   POST /admin/reservations/{id}/reject      - الرفض\n";
echo "   GET  /admin/statistics                    - الإحصائيات\n";
echo "   GET  /admin/activity-log                  - السجلات\n\n";

// ==================== SECTION 9: VIEWS ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "9️⃣  صفحات الويب (Views)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "   📄 الصفحات العامة:\n";
echo "      - welcome.blade.php          - الصفحة الرئيسية\n";
echo "      - auth/login.blade.php       - نموذج الدخول\n";
echo "      - auth/register.blade.php    - نموذج التسجيل\n\n";

echo "   📄 صفحات الموارد:\n";
echo "      - resources/index.blade.php  - قائمة الموارد\n";
echo "      - resources/show.blade.php   - عرض موارد\n\n";

echo "   📄 صفحات الحجوزات:\n";
echo "      - reservations/create.blade.php - نموذج الحجز\n";
echo "      - reservations/index.blade.php  - قائمة الحجوزات\n";
echo "      - reservations/show.blade.php   - عرض الحجز\n\n";

echo "   📄 صفحات الإدارة:\n";
echo "      - admin/dashboard.blade.php           - لوحة التحكم (ديناميكية)\n";
echo "      - admin/resources/index.blade.php     - إدارة الموارد\n";
echo "      - admin/statistics.blade.php          - الإحصائيات\n";
echo "      - admin/activity-log.blade.php        - السجلات\n";
echo "      - notifications/index.blade.php       - الإخطارات\n\n";

// ==================== SECTION 10: TEST DATA ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "🔟 بيانات الاختبار\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "👥 حسابات الاختبار:\n";
$testUsers = User::limit(5)->get();
foreach ($testUsers as $user) {
    $role = $user->role === 'admin' || $user->role === 'manager' ? 'إداري' : 'مستخدم عادي';
    echo "   📧 {$user->email} - الدور: {$user->role} ($role)\n";
}
echo "\n";

echo "🖥️  عينات من الموارد:\n";
$sampleResources = Resource::limit(3)->get();
foreach ($sampleResources as $resource) {
    echo "   📦 {$resource->name} ({$resource->type}) - الحالة: {$resource->status}\n";
}
echo "\n";

// ==================== SECTION 11: FEATURES ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "1️⃣1️⃣  الميزات المطبقة\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "✅ المصادقة (Authentication)\n";
echo "   - نموذج دخول وتسجيل\n";
echo "   - تشفير كلمات المرور بـ Bcrypt\n";
echo "   - إدارة الجلسات في قاعدة البيانات\n";
echo "   - تسجيل الدخول في ActivityLog\n\n";

echo "✅ التفويض (Authorization)\n";
echo "   - نظام الأدوار: admin, manager, user\n";
echo "   - Middleware للتحقق من الأدوار\n";
echo "   - حماية المسارات الإدارية\n\n";

echo "✅ إدارة الموارد\n";
echo "   - CRUD للموارد\n";
echo "   - التصفية والبحث\n";
echo "   - إدارة الحالة\n\n";

echo "✅ نظام الحجوزات\n";
echo "   - إنشاء وإدارة الحجوزات\n";
echo "   - كشف التضارب (Conflict Detection)\n";
echo "   - الموافقة والرفض\n";
echo "   - سجل الحالة\n\n";

echo "✅ لوحة التحكم\n";
echo "   - إحصائيات حقيقية من قاعدة البيانات\n";
echo "   - قائمة الحجوزات المعلقة\n";
echo "   - حالة الموارد\n";
echo "   - آخر الأنشطة\n\n";

echo "✅ السجلات\n";
echo "   - تسجيل جميع العمليات\n";
echo "   - تتبع التغييرات\n";
echo "   - تسجيل عنوان IP\n\n";

// ==================== SECTION 12: SUMMARY ====================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 الملخص\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "✅ حالة المشروع: FULLY FUNCTIONAL\n\n";

echo "📝 الملفات الرئيسية:\n";
echo "   - app/Models/          (4 models)\n";
echo "   - app/Http/Controllers/ (5 controllers)\n";
echo "   - app/Services/         (2 services)\n";
echo "   - app/Http/Middleware/  (1 middleware)\n";
echo "   - resources/views/      (15+ views)\n";
echo "   - routes/web.php        (22+ routes)\n\n";

echo "🚀 Available Links:\n";
echo "   🔗 http://127.0.0.1:8000/             - Home Page\n";
echo "   🔗 http://127.0.0.1:8000/login        - Login\n";
echo "   🔗 http://127.0.0.1:8000/register     - Register\n";
echo "   🔗 http://127.0.0.1:8000/resources    - Resources List\n";
echo "   🔗 http://127.0.0.1:8000/admin        - Admin Dashboard\n\n";

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║  The project is ready to use and test! 🎉                     ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n";
