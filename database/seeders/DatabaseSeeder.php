<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::beginTransaction();
        try {
            $this->call(RolePermissionSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(PositionSeeder::class);
            $this->call(EmployeeSeeder::class);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        
        DB::commit();
    }
}
