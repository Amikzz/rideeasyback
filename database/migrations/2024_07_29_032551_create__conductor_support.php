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
        Schema::create('_conductor_support', function (Blueprint $table) {
            $table->id();
            $table->string('conductor_name');
            $table->string('conductor_id');
            $table->string('request');
            $table->timestamps();

            $table->foreign('conductor_id')->references('conductor_admin_id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_conductor_support');
    }
};
