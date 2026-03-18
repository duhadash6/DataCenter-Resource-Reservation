<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create admin user
$user = \App\Models\User::firstOrCreate(
    ['email' => 'admin@test.com'],
    [
        'name' => 'Admin User',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'role' => 'admin'
    ]
);

echo "Admin user ready!\n";
echo "Email: " . $user->email . "\n";
echo "Role: " . $user->role . "\n";
echo "\nYou can now login at http://127.0.0.1:8000/login\n";
