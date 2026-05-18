<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add stock-card.view permission
        DB::table('page_permissions')->updateOrInsert(
            ['key' => 'stock-card.view'],
            [
                'label'       => 'Stock Card – View',
                'description' => 'View stock card report showing item movement history.',
                'admin'       => true,
                'supervisor'  => true,
                'operator'    => false,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );

        // Update renamed labels for item-requests
        DB::table('page_permissions')
            ->where('key', 'item-requests.view')
            ->update(['label' => 'My Stock Issues – View', 'updated_at' => now()]);

        DB::table('page_permissions')
            ->where('key', 'item-requests.create')
            ->update(['label' => 'My Stock Issues – Submit New Issue', 'updated_at' => now()]);

        DB::table('page_permissions')
            ->where('key', 'item-requests.manage')
            ->update(['label' => 'Manage Stock Issues – Approve / Reject', 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('page_permissions')->where('key', 'stock-card.view')->delete();

        DB::table('page_permissions')
            ->where('key', 'item-requests.view')
            ->update(['label' => 'My Requests – View', 'updated_at' => now()]);

        DB::table('page_permissions')
            ->where('key', 'item-requests.create')
            ->update(['label' => 'My Requests – Submit New Request', 'updated_at' => now()]);

        DB::table('page_permissions')
            ->where('key', 'item-requests.manage')
            ->update(['label' => 'Manage Requests – Approve / Reject', 'updated_at' => now()]);
    }
};
