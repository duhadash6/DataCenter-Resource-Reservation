<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$resources = \App\Models\Resource::all();
echo "Total Resources: " . $resources->count() . "\n";
echo "First 5 Resources:\n";
foreach($resources->take(5) as $r) {
    echo "  - " . $r->name . " (" . $r->type . ") - Status: " . $r->status . "\n";
}
