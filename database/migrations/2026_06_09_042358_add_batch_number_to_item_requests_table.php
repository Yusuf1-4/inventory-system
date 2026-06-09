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
        Schema::table('item_requests', function (Blueprint $table) {
            // Using 'batch_number' to match your Blade view name selection
            $table->string('batch_number')->nullable()->after('lot_number');
        });
    }

    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropColumn('batch_number');
        });
    }
};
