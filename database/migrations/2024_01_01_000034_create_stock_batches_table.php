<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_receipt_id')->constrained('stock_receipts')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('lot_number', 100);
            $table->string('batch_number', 100)->unique();
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['available', 'issued'])->default('available');
            $table->text('qr_code')->nullable();
            $table->timestamps();

            $table->index(['item_id', 'status']);
            $table->index('lot_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_batches');
    }
};
