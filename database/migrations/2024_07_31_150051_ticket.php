<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('bus_license_plate_no');
            $table->string('passenger_id');
            $table->string('status')->default('pending');
            $table->string('qr_code')->unique();
            $table->timestamps();

            $table->foreign('bus_license_plate_no')->references('bus_license_plate_no')->on('bus');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
