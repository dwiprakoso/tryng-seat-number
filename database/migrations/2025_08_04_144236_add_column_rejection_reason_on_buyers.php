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
            // Add rejection_reason column if it doesn't exist
            if (!Schema::hasColumn('buyers', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('payment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyers', function (Blueprint $table) {
            if (Schema::hasColumn('buyers', 'rejection_reason')) {
                $table->dropColumn('rejection_reason');
            }
        });
    }
};
