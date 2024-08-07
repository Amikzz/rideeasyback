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
        Schema::create('trip', function (Blueprint $table) {
            $table->string('trip_id')->primary();
            $table->string('bus_with_driver_conductor_id');
            $table->string('schedule_id');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->string('status');
            $table->string('process');
            $table->integer('no_of_tickets');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('bus_with_driver_conductor_id')->references('bus_with_driver_conductor')->on('busdriverconductor')->onDelete('cascade');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedule')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip');
    }
};
