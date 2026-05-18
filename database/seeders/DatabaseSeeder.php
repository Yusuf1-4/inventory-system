<?php

namespace Database\Seeders;

use App\Models\PagePermission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ────────────────────────────────────────────────────────────
        $users = [
            ['name' => 'Admin User',      'email' => 'admin@inventory.test',      'role' => 'admin',      'password' => Hash::make('password')],
            ['name' => 'Supervisor User', 'email' => 'supervisor@inventory.test', 'role' => 'supervisor', 'password' => Hash::make('password')],
            ['name' => 'Operator User',   'email' => 'operator@inventory.test',   'role' => 'operator',   'password' => Hash::make('password')],
        ];
        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }

        // ── Page Permissions ─────────────────────────────────────────────────
        $permissions = [
            [
                'key'         => 'items.view',
                'label'       => 'Item Master – View',
                'description' => 'View list and details of items in the master list.',
                'supervisor'  => true,
                'operator'    => true,
            ],
            [
                'key'         => 'items.manage',
                'label'       => 'Item Master – Create / Edit / Delete',
                'description' => 'Add new items, edit existing ones, bulk import, and delete items.',
                'supervisor'  => true,
                'operator'    => false,
            ],
            [
                'key'         => 'stock-receipts.view',
                'label'       => 'Stock Received – View',
                'description' => 'View list and details of stock received from suppliers.',
                'supervisor'  => true,
                'operator'    => true,
            ],
            [
                'key'         => 'stock-receipts.create',
                'label'       => 'Stock Received – Record New Receipt',
                'description' => 'Record new stock received from a supplier.',
                'supervisor'  => true,
                'operator'    => true,
            ],
            [
                'key'         => 'item-requests.view',
                'label'       => 'My Stock Issues – View',
                'description' => 'View own stock issue history.',
                'supervisor'  => true,
                'operator'    => true,
            ],
            [
                'key'         => 'item-requests.create',
                'label'       => 'My Stock Issues – Submit New Issue',
                'description' => 'Submit a new stock issue for approval.',
                'supervisor'  => true,
                'operator'    => true,
            ],
            [
                'key'         => 'item-requests.manage',
                'label'       => 'Manage Stock Issues – Approve / Reject',
                'description' => 'View all stock issues and approve or reject them.',
                'supervisor'  => true,
                'operator'    => false,
            ],
            [
                'key'         => 'stock-batches.view',
                'label'       => 'Stock Batches – View',
                'description' => 'Browse and search all batch numbers across lots.',
                'supervisor'  => true,
                'operator'    => false,
            ],
            [
                'key'         => 'stock-card.view',
                'label'       => 'Stock Card – View',
                'description' => 'View stock card report showing item movement history.',
                'supervisor'  => true,
                'operator'    => false,
            ],
        ];

        foreach ($permissions as $data) {
            PagePermission::updateOrCreate(
                ['key' => $data['key']],
                array_merge($data, ['admin' => true])
            );
        }
    }
}
