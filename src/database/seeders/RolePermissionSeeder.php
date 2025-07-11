<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Role ID 1: Full access (all permissions)
        $allPermissions = Permission::all();
        $superAdminRole = Role::find(1);
        if ($superAdminRole) {
            $superAdminRole->syncPermissions($allPermissions);
        }

        // Role ID 2: Limited permissions
        $allowedPermissionIds = [
            7, 8, 9, 10,    // barang::keluar
            13, 14, 15, 16, // barang::masuk
            19,20,          // view_gudang
            37,             // Overlook widget
        ];

        $limitedPermissions = Permission::whereIn('id', $allowedPermissionIds)->get();
        $gudangRole = Role::find(2);
        if ($gudangRole) {
            $gudangRole->syncPermissions($limitedPermissions);
        }
    }
}
