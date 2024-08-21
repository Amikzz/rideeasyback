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
        Schema::create('bus', function (Blueprint $table) {
            $table->string('bus_license_plate_no')->primary();
            $table->integer('capacity');
            $table->string('status');
            $table->string('route_id')->nullable();
            $table->foreign('route_id')->references('route_id')->on('route');
            $table->string('bus_parked_venue')->nullable();
            $table->string('bus_type')->nullable();
            $table->dateTime('lastMaintain')->nullable();
            $table->timestamps();
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->dateTime('lastUpdateLocation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus');
    }
};
