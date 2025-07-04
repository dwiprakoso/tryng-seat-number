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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_handphone', 20);
            $table->string('nama_instagram')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('ukuran_jersey')->nullable();
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('ticket_id');
            $table->decimal('ticket_price', 10, 2)->default(0);
            $table->decimal('admin_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('external_id')->unique();
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_invoice_url')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'failed'])->default('pending');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');

            // Index untuk performa yang lebih baik
            $table->index('ticket_id');
            $table->index('no_handphone');
            $table->index('external_id');
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
    }
};
