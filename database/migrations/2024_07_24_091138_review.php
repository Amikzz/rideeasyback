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
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('bus_license_plate_no');
            $table->string('review');
            $table->timestamps();

            // Foreign key constraint bus license plate no
            $table->foreign('bus_license_plate_no')->references('bus_license_plate_no')->on('bus')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
