<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Mobilier',
                'slug' => 'mobilier',
                'description' => 'Meubles de qualité pour votre intérieur',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Décoration Murale',
                'slug' => 'decoration-murale',
                'description' => 'Tableaux, miroirs et décorations murales',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Luminaires',
                'slug' => 'luminaires',
                'description' => 'Éclairage et lampes décoratives',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Textiles',
                'slug' => 'textiles',
                'description' => 'Coussins, rideaux et tapis',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Accessoires',
                'slug' => 'accessoires',
                'description' => 'Vases, bougies et petits objets déco',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Événementiel',
                'slug' => 'evenementiel',
                'description' => 'Décoration pour événements spéciaux',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Add subcategories
        $mobilier = Category::where('slug', 'mobilier')->first();

        $subcategories = [
            [
                'name' => 'Canapés',
                'slug' => 'canapes',
                'parent_id' => $mobilier->id,
                'is_active' => true,
            ],
            [
                'name' => 'Tables',
                'slug' => 'tables',
                'parent_id' => $mobilier->id,
                'is_active' => true,
            ],
            [
                'name' => 'Chaises',
                'slug' => 'chaises',
                'parent_id' => $mobilier->id,
                'is_active' => true,
            ],
        ];

        foreach ($subcategories as $subcategory) {
            Category::create($subcategory);
        }
    }
}
