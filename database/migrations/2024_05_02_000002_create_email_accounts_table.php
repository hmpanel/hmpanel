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
        Schema::create('email_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password');
            $table->unsignedBigInteger('web_app_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_accounts');
    }
};
