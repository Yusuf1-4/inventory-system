<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('page_permissions')->updateOrInsert(
            ['key' => 'stock-batches.view'],
            [
                'label'       => 'Stock Batches – View',
                'description' => 'Browse and search all batch numbers across lots.',
                'admin'       => true,
                'supervisor'  => true,
                'operator'    => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('page_permissions')->where('key', 'stock-batches.view')->delete();
    }
};
