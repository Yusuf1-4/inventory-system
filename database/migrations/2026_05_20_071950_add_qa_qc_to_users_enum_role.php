<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For MySQL: Redefine the enum to include the new roles
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'supervisor', 'operator', 'qa', 'qc') NOT NULL DEFAULT 'operator'");
    }

    public function down(): void
    {
        // Revert back if needed (ensure no QA/QC users exist before rolling back)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'supervisor', 'operator') NOT NULL DEFAULT 'operator'");
    }
};
