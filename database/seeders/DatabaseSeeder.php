<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'student_id' => '30-31520',
                'firstname' => 'SorsuBulan',
                'middlename' => '',
                'lastname' => 'Registrar',
                'phone_number' => '09123456789',
                'year' => Null,
                'course' => 'BSIT',
                'email' => 'registrar@gmail.com',
                'role' => 'registrar',
                'student_type' => Null,
                'password' => Hash::make('password'),
            ],
            [
                'student_id' => '31-30521',
                'firstname' => 'John',
                'middlename' => '',
                'lastname' => 'Doe',
                'phone_number' => '09999999999',
                'year' => '4th Year',
                'course' => 'BSIT',
                'email' => 'student@gmail.com',
                'role' => 'student',
                'student_type' => 'enrolled',
                'password' => Hash::make('password'),
            ],
        ]);
       // User::factory()->count(10)->create();
    }
}
