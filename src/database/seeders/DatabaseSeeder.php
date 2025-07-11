<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (User::count() == 0) {
            // Ensure roles exist
            Role::firstOrCreate(['name' => 'super_admin']);
            Role::firstOrCreate(['name'=> 'petugas']);

            $superAdmin = User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
            $superAdmin->assignRole('super_admin');
            
            $petugas = User::factory()->create([
                'name' => 'Petugas',
                'email' => 'petugas@warehouse.com',
                'password' => bcrypt('password'),
            ]);
            $petugas->assignRole('petugas');
        }


        $this->call([
            GudangSeeder::class,
            ThemeSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}