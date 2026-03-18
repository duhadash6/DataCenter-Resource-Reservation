<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = \Illuminate\Http\Request::capture());

use App\Models\Resource;

$resource = Resource::find(1);
if ($resource) {
    echo "✅ Resource found\n";
    echo "ID: " . $resource->id . "\n";
    echo "Name: " . $resource->name . "\n";
    echo "Type: " . $resource->type . "\n";
    echo "Status: " . $resource->status . "\n";
    echo "Specs: " . $resource->specs . "\n";
} else {
    echo "❌ Resource NOT found\n";
    echo "Total resources: " . Resource::count() . "\n";
}
