<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrateur',
                'slug' => 'admin',
                'description' => 'Accès complet au système',
            ],
            [
                'name' => 'Client',
                'slug' => 'customer',
                'description' => 'Utilisateur client standard',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
