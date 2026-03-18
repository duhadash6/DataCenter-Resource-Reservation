<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = \Illuminate\Http\Request::capture());

use App\Models\Reservation, App\Models\Resource, App\Models\User;

// Get admin user
$admin = User::where('role', 'admin')->first();
if (!$admin) {
    echo "Admin user not found. Please create one first.\n";
    exit(1);
}

// Get some resources
$resources = Resource::limit(3)->get();
if ($resources->isEmpty()) {
    echo "No resources found. Please create resources first.\n";
    exit(1);
}

// Create a regular user if not exists
$user = User::where('email', 'test@test.com')->first();
if (!$user) {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@test.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);
    echo "Created test user: test@test.com\n";
}

// Create pending reservations
$now = now();
foreach ($resources as $index => $resource) {
    Reservation::create([
        'user_id' => $user->id,
        'resource_id' => $resource->id,
        'start_at' => $now->copy()->addHours($index + 2),
        'end_at' => $now->copy()->addHours($index + 4),
        'status' => 'pending',
        'justification' => 'Test reservation ' . ($index + 1),
    ]);
}

echo "Pending reservations created successfully!\n";
echo "Total pending reservations: " . Reservation::where('status', 'pending')->count() . "\n";
