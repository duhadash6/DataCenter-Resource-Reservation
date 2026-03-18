<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create sample reservations
$resources = \App\Models\Resource::take(3)->get();
$user = \App\Models\User::where('role', 'admin')->first();

if($user && $resources) {
    foreach($resources as $index => $resource) {
        $startDate = now()->addDays($index + 1);
        $endDate = $startDate->copy()->addHours(6);
        
        \App\Models\Reservation::firstOrCreate(
            [
                'user_id' => $user->id,
                'resource_id' => $resource->id,
                'start_at' => $startDate,
            ],
            [
                'end_at' => $endDate,
                'status' => $index === 0 ? 'approved' : 'pending',
                'justification' => 'Testing reservation system'
            ]
        );
    }
    
    echo "Sample reservations created!\n";
    echo "Total reservations: " . \App\Models\Reservation::count() . "\n";
}
