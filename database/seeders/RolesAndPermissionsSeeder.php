<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // الصلاحيات الأساسية (يمكن التوسع لاحقًا)
        $permissions = [
            'manage campaigns',
            'manage users',
            'manage withdrawals',
            'manage invoices',
            'manage settings',

            'publish tasks',
            'withdraw balance'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // الأدوار
        $admin     = Role::firstOrCreate(['name' => 'admin']);
        $advertiser = Role::firstOrCreate(['name' => 'advertiser']);
        $publisher  = Role::firstOrCreate(['name' => 'publisher']);

        // صلاحيـات المشرف
        $admin->givePermissionTo(Permission::all());

        // صلاحيـات المعلن
        $advertiser->givePermissionTo([
            'manage campaigns',
            'manage invoices',
        ]);

        // صلاحيـات الناشر
        $publisher->givePermissionTo([
            'publish tasks',
            'withdraw balance'
        ]);
    }
}
