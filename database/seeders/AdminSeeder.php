<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $customerRole = Role::where('slug', 'customer')->first();

        // Create admin user
        User::create([
            'name' => 'Administrateur',
            'email' => 'Lamaisonp2a@outlook.com',
            'password' => Hash::make('Lamaisonp2a'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        // Create test customer
       /*  User::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => Hash::make('Client123!'),
            'role_id' => $customerRole->id,
            'email_verified_at' => now(),
        ]); */
    }
}
