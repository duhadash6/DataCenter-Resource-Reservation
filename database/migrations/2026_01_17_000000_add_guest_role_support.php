<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the users table to allow 'guest' role
        // No schema changes needed - just documenting that guest role is now supported
        // The role enum in the users table will accept: 'admin', 'manager', 'user', 'guest'
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
