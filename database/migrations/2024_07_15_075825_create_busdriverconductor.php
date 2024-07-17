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
        Schema::create('busdriverconductor', function (Blueprint $table) {
            $table->string('bus_with_driver_conductor')->primary();
            $table->dateTime('date_time');
            $table->string('bus_license_plate_no');
            $table->string('driver_id');
            $table->string('conductor_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('bus_license_plate_no')->references('bus_license_plate_no')->on('bus')->onDelete('cascade');
            $table->foreign('driver_id')->references('driver_id')->on('driver')->onDelete('cascade');
            $table->foreign('conductor_id')->references('conductor_admin_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busdriverconductor');
    }
};
