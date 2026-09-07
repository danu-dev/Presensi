<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Insert users (1 admin, 1 guru, 10 students)
        DB::table('users')->insert([
            [
                'name'       => 'Admin 1',
                'username'   => 'admin1',
                'email'      => 'admin1@example.com',
                'password'   => bcrypt('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Guru 1',
                'username'   => 'guru1',
                'email'      => 'guru1@example.com',
                'password'   => bcrypt('password'),
                'role'       => 'guru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $names = [
            "M.Fahrur Rozi",
            "Moch Bayu Ardiansyah",
            "Mohammad Afdanu Aprilian Saputra",
            "Nabila Zahrotul Amalia",
            "Radittya Ardiansyah",
            "Rizky Annisa Mutiara",
            "Redhita Virginia Candra",
            "Vera Amelia",
            "Wildatul Lailiyah",
            "Winanda Aprilia Putri"
        ];

        $students = [];
        foreach ($names as $index => $name) {
            $baseSlug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', str_replace([' ', '.'], '', $name)));
            $username = substr($baseSlug, 0, 15) . ($index + 1);
            $email = strtolower(str_replace([' ', '.'], '_', $name)) . '@example.com';
            $students[] = [
                'name'       => $name,
                'username'   => $username,
                'email'      => $email,
                'password'   => bcrypt('password'),
                'role'       => 'user',
                'nisn'       => '12345891' . ($index + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($students);

        // Insert locations
        DB::table('locations')->insert([
            [
                'name' => 'Xl RPL 2',
                'latitude' => -8.15627,
                'longitude' => 113.43497,
                'radius' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JURUSAN',
                'latitude' => -8.15530,
                'longitude' => 113.438508,
                'radius' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert rooms
        DB::table('rooms')->insert([
            [
                'name' => 'TEORI 9',
                'guru_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JURUSAN',
                'guru_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert attendance records for each student
        $studentIds = DB::table('users')->where('role', 'user')->pluck('id')->toArray();
        $attendances = [];
        foreach ($studentIds as $userId) {
            // First attendance record
            $attendances[] = [
                'user_id' => $userId,
                'location_id' => rand(1, 2),
                'room_id' => rand(1, 2),
                'check_in' => now()->subDays(rand(0, 5)),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            // Second attendance record
            $attendances[] = [
                'user_id' => $userId,
                'location_id' => rand(1, 2),
                'room_id' => rand(1, 2),
                'check_in' => now()->subDays(rand(0, 5)),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('attendances')->insert($attendances);
    }
}
