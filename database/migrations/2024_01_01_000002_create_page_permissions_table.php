<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // e.g. 'items.manage'
            $table->string('label');                // Display name
            $table->string('description')->nullable();
            $table->boolean('admin')->default(true);      // always true, not editable
            $table->boolean('supervisor')->default(false);
            $table->boolean('operator')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_permissions');
    }
};
