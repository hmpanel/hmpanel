<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ftp_accounts', function (Blueprint $table) {
            $table
                ->foreign('web_app_id')
                ->references('id')
                ->on('web_apps')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ftp_accounts', function (Blueprint $table) {
            $table->dropForeign(['web_app_id']);
        });
    }
};
