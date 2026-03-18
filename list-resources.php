<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = \Illuminate\Http\Request::capture());

use App\Models\Resource;

$resources = Resource::orderBy('id')->get();
echo "Resources in database:\n";
foreach ($resources as $r) {
    echo "ID: " . $r->id . " | Name: " . $r->name . " | Status: " . $r->status . "\n";
}
echo "\nFirst resource ID: " . Resource::first()->id . "\n";
