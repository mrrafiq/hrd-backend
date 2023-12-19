<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "administrator",
            "basic_employee"
        ];

        try {
            foreach ($roles as $value) {
                Role::create(['name' => $value]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
        $permissions = [
            "browse_user",
            "read_user",
            "edit_user",
            "delete_user",
            "add_user",
            "browse_employee",
            "read_employee",
            "edit_employee",
            "delete_employee",
            "add_employee",
        ];

        try {
            foreach ($permissions as $value) {
                Permission::create(['name' => $value]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        $administrator = Role::findByName('administrator');
        $administrator->givePermissionTo($permissions);
    }
}
