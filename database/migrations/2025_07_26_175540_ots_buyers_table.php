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
        Schema::create('ots_sales', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_handphone', 20);
            $table->unsignedBigInteger('ticket_id');
            $table->integer('quantity');
            $table->decimal('ticket_price', 10, 2);
            $table->decimal('admin_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'cashless']);
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->index(['created_at']);
            $table->index(['payment_method']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ots_sales');
    }
};
