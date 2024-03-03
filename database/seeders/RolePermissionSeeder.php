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
            "browse_roles",
            "read_roles",
            "edit_roles",
            "delete_roles",
            "add_roles",
            "browse_permissions",
            "read_permissions",
            "edit_permissions",
            "delete_permissions",
            "add_permissions",
            "browse_department",
            "read_department",
            "edit_department",
            "delete_department",
            "add_department",
            "browse_positions",
            "read_positions",
            "edit_positions",
            "delete_positions",
            "add_positions",
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
