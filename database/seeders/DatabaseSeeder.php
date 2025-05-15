<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Siswa 1', 'email' => 'siswa1@example.com', 'password' => bcrypt('password'), 'role' => 'user'],
            ['name' => 'Guru 1', 'email' => 'guru1@example.com', 'password' => bcrypt('password'), 'role' => 'guru'],
            ['name' => 'Admin 1', 'email' => 'admin1@example.com', 'password' => bcrypt('password'), 'role' => 'admin'],
        ]);

        DB::table('locations')->insert([
            ['name' => 'Kelas A', 'latitude' => -6.2088, 'longitude' => 106.8456, 'radius' => 50000000],
            ['name' => 'Kelas B', 'latitude' => -6.2090, 'longitude' => 106.8460, 'radius' => 10000000],
        ]);

        DB::table('rooms')->insert([
            ['name' => 'Ruang 10A', 'guru_id' => 2],
            ['name' => 'Ruang 10B', 'guru_id' => 2],
        ]);

        DB::table('attendances')->insert([
            'user_id' => 1,
            'location_id' => 1,
            'room_id' => 1,
            'check_in' => now(),
            'status' => 'pending',
        ]);
    }
}