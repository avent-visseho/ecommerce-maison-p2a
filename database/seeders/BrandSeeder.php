<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Maison P2A',
                'slug' => 'maison-p2a',
                'description' => 'Notre collection exclusive',
                'is_active' => true,
            ],
            [
                'name' => 'Nordic Home',
                'slug' => 'nordic-home',
                'description' => 'Design scandinave épuré',
                'is_active' => true,
            ],
            [
                'name' => 'Luxe Déco',
                'slug' => 'luxe-deco',
                'description' => 'Décoration de luxe',
                'is_active' => true,
            ],
            [
                'name' => 'Urban Style',
                'slug' => 'urban-style',
                'description' => 'Style urbain moderne',
                'is_active' => true,
            ],
            [
                'name' => 'Classic Touch',
                'slug' => 'classic-touch',
                'description' => 'Élégance classique',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
