<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_receipts', function (Blueprint $table) {
            $table->enum('type', ['supplier', 'production'])->default('supplier')->after('id');
            $table->foreignId('item_request_id')->nullable()->constrained('item_requests')->nullOnDelete()->after('type');
            // Make supplier_name nullable — production returns don't have a supplier
            $table->string('supplier_name')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('stock_receipts', function (Blueprint $table) {
            $table->dropForeign(['item_request_id']);
            $table->dropColumn(['type', 'item_request_id']);
            $table->string('supplier_name')->nullable(false)->change();
        });
    }
};
