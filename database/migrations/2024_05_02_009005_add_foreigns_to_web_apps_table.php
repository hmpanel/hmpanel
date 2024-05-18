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
        Schema::table('web_apps', function (Blueprint $table) {
            $table
                ->foreign('domain_id')
                ->references('id')
                ->on('domains')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('web_apps', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
        });
    }
};
