<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // assign employee from user

        Employee::create([
            'user_id' => 2,
            'employee_number' => Employee::GenerateEmployeeNumber(),
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'Jakarta',
            'address' => 'Jl. Jalan',
            'job_title_id' => 1,
            'grade' => '1',
            'is_active' => '1'
        ]);

        Employee::create([
            'user_id' => 3,
            'employee_number' => Employee::GenerateEmployeeNumber(),
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'Jakarta',
            'address' => 'Jl. Jalan',
            'job_title_id' => 2,
            'grade' => '1',
            'is_active' => '1'
        ]);

        Employee::create([
            'user_id' => 3,
            'employee_number' => Employee::GenerateEmployeeNumber(),
            'phone_number' => '081234567890',
            'date_of_birth' => '1990-01-01',
            'place_of_birth' => 'Jakarta',
            'address' => 'Jl. Jalan',
            'job_title_id' => 3,
            'grade' => '1',
            'is_active' => '1'
        ]);
    }
}
