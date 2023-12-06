<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('administrator');
        $admin->givePermissionTo(Permission::all());

        // create user employee
        $employee_1 = User::create([
            'name' => 'Rafiq',
            'email' => 'rafiq@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $employee_1->assignRole('employee');
    }
}
