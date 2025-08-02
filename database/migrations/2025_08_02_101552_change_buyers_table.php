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
            // Drop Xendit related columns
            $table->dropColumn([
                'xendit_invoice_id',
                'xendit_invoice_url',
                'payment_method',
                'payment_channel'
            ]);

            // Modify payment_status enum to remove xendit-specific statuses
            $table->dropColumn('payment_status');

            // Add new payment_status with manual payment statuses
            $table->enum('payment_status', [
                'pending',
                'waiting_confirmation',
                'confirmed',
                'rejected'
            ])->default('pending')->after('total_amount');

            // Add manual payment related columns
            $table->string('payment_code', 3)->unique()->nullable()->after('payment_status');
            $table->string('payment_proof')->nullable()->after('payment_code');
            // Remove the 'after' clause since 'payment_notes' doesn't exist
            $table->timestamp('payment_confirmed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            // Remove manual payment columns
            $table->dropColumn([
                'payment_code',
                'payment_proof',
                'payment_confirmed_at',
            ]);

            // Drop the new payment_status
            $table->dropColumn('payment_status');

            // Restore original Xendit columns
            $table->string('xendit_invoice_id')->nullable();
            $table->string('xendit_invoice_url')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_channel')->nullable();

            // Restore original payment_status
            $table->enum('payment_status', [
                'pending',
                'paid',
                'expired',
                'failed'
            ])->default('pending');
        });
    }
};
