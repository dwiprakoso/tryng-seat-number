<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->text('qr_code')->nullable()->after('external_id');
            $table->string('qr_code_path')->nullable()->after('qr_code');
        });
    }

    public function down()
    {
        Schema::table('buyers', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'qr_code_path']);
        });
    }
};
