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
        Schema::table('tech_versions', function (Blueprint $table) {
            $table
                ->foreign('technology_id')
                ->references('id')
                ->on('technologies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tech_versions', function (Blueprint $table) {
            $table->dropForeign(['technology_id']);
        });
    }
};
