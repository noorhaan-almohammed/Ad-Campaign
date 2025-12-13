<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            SettingsSeeder::class,
        ]);

        // $user = User::firstOrCreate(
        //     ['email' => 'admin@example.com'],
        //     ['name' => 'Admin', 'password' => Hash::make('password')]
        // );
        // $user->assignRole('admin');
    }
}
