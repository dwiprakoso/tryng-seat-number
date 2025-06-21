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
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->timestamp('payment_updated_at')->nullable()->after('paid_at');
            $table->string('payment_method')->nullable()->after('payment_updated_at');
            $table->string('payment_channel')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn([
                'paid_at',
                'payment_updated_at',
                'payment_method',
                'payment_channel'
            ]);
        });
    }
};
