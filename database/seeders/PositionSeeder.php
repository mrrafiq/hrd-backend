<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position\Department;
use App\Models\Position\JobTitle;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert department
        $departments = [
            "IT",
            "HRD",
            "Finance",
            "Marketing",
            "Sales",
            "Production",
            "Purchasing",
            "Logistic",
            "Warehouse",
            "Quality Control",
            "Maintenance",
            "Security",
            "General Affair",
            "Legal",
            "Management",
        ];

        try {
            foreach ($departments as $value) {
                Department::create(['name' => $value]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        //insert job title
        $job_titles = [
            // jajaran direksi
            [
                "name" => "Director",
                "description" => "Director",
            ],
            [
                "name" => "President Director",
                "description" => "President Director",
            ],
            [
                "name" => "Vice President Director",
                "description" => "Vice President Director",
            ],
            [
                "name" => "Commissioner",
                "description" => "Commissioner",
            ],
            [
                "name" => "President Commissioner",
                "description" => "President Commissioner",
            ],
            [
                "name" => "Vice President Commissioner",
                "description" => "Vice President Commissioner",
            ],
            [
                "name" => "IT Manager",
                "description" => "IT Manager",
                "department_id" => 1,
            ],
            [
                "name" => "IT Staff",
                "description" => "IT Staff",
                "department_id" => 1,
            ],
            [
                "name" => "HRD Manager",
                "description" => "HRD Manager",
                "department_id" => 2,
            ],
            [
                "name" => "HRD Staff",
                "description" => "HRD Staff",
                "department_id" => 2,
            ],
            [
                "name" => "Finance Manager",
                "description" => "Finance Manager",
                "department_id" => 3,
            ],
            [
                "name" => "Finance Staff",
                "description" => "Finance Staff",
                "department_id" => 3,
            ],
            [
                "name" => "Marketing Manager",
                "description" => "Marketing Manager",
                "department_id" => 4,
            ],
            [
                "name" => "Marketing Staff",
                "description" => "Marketing Staff",
                "department_id" => 4,
            ],
            [
                "name" => "Sales Manager",
                "description" => "Sales Manager",
                "department_id" => 5,
            ],
            [
                "name" => "Sales Staff",
                "description" => "Sales Staff",
                "department_id" => 5,
            ],
            [
                "name" => "Production Manager",
                "description" => "Production Manager",
                "department_id" => 6,
            ],
            [
                "name" => "Production Staff",
                "description" => "Production Staff",
                "department_id" => 6,
            ],
            [
                "name" => "Purchasing Manager",
                "description" => "Purchasing Manager",
                "department_id" => 7,
            ],
            [
                "name" => "Purchasing Staff",
                "description" => "Purchasing Staff",
                "department_id" => 7,
            ],
            [
                "name" => "Logistic Manager",
                "description" => "Logistic Manager",
                "department_id" => 8,
            ],
            [
                "name" => "Logistic Staff",
                "description" => "Logistic",
                "department_id" => 8,
            ]
        ];

        try {
            foreach ($job_titles as $value) {
                JobTitle::create($value);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
