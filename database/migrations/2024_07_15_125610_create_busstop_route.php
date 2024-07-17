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
        Schema::create('busstop_route', function (Blueprint $table) {
            $table->string('bus_stop_id');
            $table->string('route_id');
            $table->primary(['bus_stop_id', 'route_id']);

            // Foreign key constraint
            $table->foreign('bus_stop_id')->references('bus_stop_id')->on('busstop')->onDelete('cascade');
            $table->foreign('route_id')->references('route_id')->on('route')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busstop_route');
    }
};
