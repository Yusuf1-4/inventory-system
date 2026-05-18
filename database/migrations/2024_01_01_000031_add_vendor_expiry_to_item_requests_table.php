<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->string('vendor_name', 255)->nullable()->after('notes');
            $table->date('expiry_date')->nullable()->after('vendor_name');
        });
    }

    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropColumn(['vendor_name', 'expiry_date']);
        });
    }
};
