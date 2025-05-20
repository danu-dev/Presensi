<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert users (1 admin, 1 guru, 50 students)
        DB::table('users')->insert([
            ['name' => 'Admin 1', 'email' => 'admin1@example.com', 'password' => bcrypt('password'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guru 1', 'email' => 'guru1@example.com', 'password' => bcrypt('password'), 'role' => 'guru', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert 50 students
        $students = [];
        for ($i = 1; $i <= 50; $i++) {
            $students[] = [
                'name' => "Siswa $i",
                'email' => "siswa$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'user',
                'nisn'=>"123458910$i",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($students);

        // Insert locations
        DB::table('locations')->insert([
            ['name' => 'Kelas A', 'latitude' => -8.2088, 'longitude' => 106.8456, 'radius' => 5000, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kelas B', 'latitude' => -6.2090, 'longitude' => 106.8460, 'radius' => 1000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert rooms
        DB::table('rooms')->insert([
            ['name' => 'Ruang 10A', 'guru_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ruang 10B', 'guru_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert attendance records for each student in both rooms
        $attendances = [];
        for ($userId = 3; $userId <= 52; $userId++) {
            $attendances[] = [
                'user_id' => $userId,
                'location_id' => 1,
                'room_id' => 1,
                'check_in' => now()->subDays(rand(0, 5)),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $attendances[] = [
                'user_id' => $userId,
                'location_id' => 2,
                'room_id' => 2,
                'check_in' => now()->subDays(rand(0, 5)),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('attendances')->insert($attendances);
    }
}
