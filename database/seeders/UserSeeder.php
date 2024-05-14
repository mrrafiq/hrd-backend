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
            'login_as' => 'system_administrator',
            'avatar' => '/default-avatar.png'
        ]);

        $admin->assignRole('administrator');
        $admin->givePermissionTo(Permission::all());

        // create user employee
        $employee_1 = User::create([
            'name' => 'Rafiq',
            'email' => 'rafiq@gmail.com',
            'password' => bcrypt('password'),
            'login_as' => 'employee',
            'avatar' => '/default-avatar.png'
        ]);

        $employee_2 = User::create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => bcrypt('password'),
            'login_as' => 'employee',
            'avatar' => '/default-avatar.png'
        ]);

        $employee_3 = User::create([
            'name' => 'Withney',
            'email' => 'withney@gmail.com',
            'password' => bcrypt('password'),
            'login_as' => 'guest',
            'avatar' => '/default-avatar.png'
        ]);

        // $employee_1->assignRole('employee');
    }
}
