<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    // Delete existing test user if any
    User::where('email', 'admin@test.com')->delete();
    
    // Create new test user
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@test.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'email_verified_at' => now()
    ]);
    
    echo "✅ User created successfully!\n";
    echo "📧 Email: admin@test.com\n";
    echo "🔐 Password: password123\n";
    echo "👤 Role: admin\n";
    echo "\n✨ Go to http://127.0.0.1:8000/login and try these credentials\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
