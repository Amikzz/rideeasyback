<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Driver;
use App\Models\Person;
use App\Models\Route;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'conductor_admin_id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Person::factory()->create([
            'id_number' => '1234567890',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'password' => bcrypt('password'),
            'dob' => Carbon::today(),
            'gender' => 'Male',
            'phone_no' => '1234567890',
            'address' => '123 Main St',
        ]);

        Bus::factory()->create([
            'bus_license_plate_no' => 'ABC-123',
            'capacity' => 50,
            'status' => 'active',
            'lastUpdateLocation' =>Carbon::today(),
        ]);

        Driver::factory()->create([
            'id_number' => '1234567890',
            'driver_id' => 1,
        ]);

        Route::factory()->create([
            'route_id' => 1,
            'route_number' => '138',
            'start_location' => 'Colombo Fort',
            'end_location' => 'Kottawa',
            'distance' => 20,
            'duration' => 120,
        ]);


    }
}
