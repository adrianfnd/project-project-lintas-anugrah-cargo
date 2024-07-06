<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $adminId = Str::uuid()->toString();
        DB::table('admins')->insert([
            'id' => $adminId,
            'name' => 'Admin User',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'admin_id' => $adminId,
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@lintasanugrahcargo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $managerOperasionalId = Str::uuid()->toString();
        DB::table('managers_operasional')->insert([
            'id' => $managerOperasionalId,
            'created_by' => $adminId,
            'name' => 'Manager Operasional User',
            'phone_number' => '1234567890',
            'address' => 'Manager Operasional Address',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'manager_operasional_id' => $managerOperasionalId,
            'name' => 'Manager Operasional User',
            'username' => 'manageroperasional',
            'email' => 'manageroperasional@lintasanugrahcargo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $operatorId = Str::uuid()->toString();
        DB::table('operators')->insert([
            'id' => $operatorId,
            'created_by' => $adminId,
            'name' => 'Operator User',
            'phone_number' => '1234567890',
            'address' => 'Operator Address',
            'region' => 'Region 1',
            'region_latitude' => 10.12345678,
            'region_longitude' => 20.12345678,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'operator_id' => $operatorId,
            'name' => 'Operator User',
            'username' => 'operator',
            'email' => 'operator@lintasanugrahcargo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $driverId = Str::uuid()->toString();
        DB::table('drivers')->insert([
            'id' => $driverId,
            'created_by' => $adminId,
            'name' => 'Driver User',
            'image' => $faker->imageUrl($width = 640, $height = 480, 'people', true, 'Faker'),
            'phone_number' => '0987654321',
            'license_number' => 'D123456',
            'vehicle_name' => 'Driver Vehicle',
            'address' => 'Driver Address',
            'rate' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => Str::uuid()->toString(),
            'driver_id' => $driverId,
            'name' => 'Driver User',
            'username' => 'driver',
            'email' => 'driver@lintasanugrahcargo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
