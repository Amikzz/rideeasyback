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
        Schema::create('safety_button', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('issue_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safety_button');
    }
};
