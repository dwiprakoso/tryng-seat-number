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
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn([
                'nama_instagram',
                'kode_pos',
                'ukuran_jersey',
                'qr_code',
                'qr_code_path',
                'paid_at',
                'payment_updated_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn([
                'nama_instagram',
                'kode_pos',
                'ukuran_jersey',
                'qr_code',
                'qr_code_path',
                'paid_at',
                'payment_updated_at'
            ]);
        });
    }
};
