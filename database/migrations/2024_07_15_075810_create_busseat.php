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
        Schema::create('busseat', function (Blueprint $table) {
            $table->string('seat_number')->primary();
            $table->string('bus_license_plate_no');

            // Foreign key constraint
            $table->foreign('bus_license_plate_no')->references('bus_license_plate_no')->on('bus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busseat');
    }
};
