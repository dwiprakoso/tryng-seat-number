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
            $table->string('no_handphone', 15);
            $table->string('nama_instagram');
            $table->text('alamat_lengkap');
            $table->string('kode_pos', 10);
            $table->enum('ukuran_jersey', ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']);
            $table->unsignedBigInteger('ticket_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');

            // Index untuk performa yang lebih baik
            $table->index('ticket_id');
            $table->index('no_handphone');
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
