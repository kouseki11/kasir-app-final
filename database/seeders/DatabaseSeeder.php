<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        Role::create(['name' => 'administrator']);
        Role::create(['name' => 'staff']);

        $user = User::create([
            'name' => 'Admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@ujikom',

        ]);

        $userStaff = User::create([
            'name' => 'Staff',
            'password' => bcrypt('staff'),
            'email' => 'staff@ujikom',
        ]);

        $user->assignRole('administrator');
        $userStaff->assignRole('staff');
    }
}
