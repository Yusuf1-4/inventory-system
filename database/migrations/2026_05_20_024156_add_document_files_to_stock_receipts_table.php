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
        Schema::table('stock_receipts', function (Blueprint $blueprint) {
            // Adding paths as nullable text/string columns after 'notes'
            $blueprint->string('grn_file')->nullable()->after('notes');
            $blueprint->string('do_file')->nullable()->after('grn_file');
            $blueprint->string('coa_file')->nullable()->after('do_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_receipts', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['grn_file', 'do_file', 'coa_file']);
        });
    }
};
