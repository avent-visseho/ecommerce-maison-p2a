<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobilier = Category::where('slug', 'mobilier')->first();
        $luminaires = Category::where('slug', 'luminaires')->first();
        $textiles = Category::where('slug', 'textiles')->first();
        $accessoires = Category::where('slug', 'accessoires')->first();
        $decoration = Category::where('slug', 'decoration-murale')->first();

        $maisonP2A = Brand::where('slug', 'maison-p2a')->first();
        $nordic = Brand::where('slug', 'nordic-home')->first();
        $luxe = Brand::where('slug', 'luxe-deco')->first();

        $products = [
            /* [
                'name' => 'Canapé Scandinave 3 places',
                'description' => 'Canapé confortable au design épuré',
                'long_description' => 'Ce magnifique canapé scandinave allie confort et élégance. Avec ses lignes épurées et son revêtement en tissu de qualité, il apportera une touche de modernité à votre salon.',
                'price' => 450000,
                'sale_price' => 399000,
                'stock' => 15,
                'category_id' => $mobilier->id,
                'brand_id' => $nordic->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Lampe Suspendue Design',
                'description' => 'Luminaire moderne en métal doré',
                'long_description' => 'Cette lampe suspendue au design contemporain ajoutera une touche d\'élégance à votre intérieur. Fabriquée en métal doré de haute qualité.',
                'price' => 85000,
                'stock' => 25,
                'category_id' => $luminaires->id,
                'brand_id' => $luxe->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Coussin Velours Bleu',
                'description' => 'Coussin décoratif 45x45cm',
                'long_description' => 'Coussin en velours doux au toucher, parfait pour ajouter une touche de couleur et de confort à votre canapé ou votre lit.',
                'price' => 12000,
                'sale_price' => 9500,
                'stock' => 50,
                'category_id' => $textiles->id,
                'brand_id' => $maisonP2A->id,
                'is_active' => true,
            ],
            [
                'name' => 'Vase Céramique Artisanal',
                'description' => 'Vase décoratif fait main',
                'long_description' => 'Vase en céramique fait main par des artisans locaux. Chaque pièce est unique. Idéal pour vos compositions florales.',
                'price' => 28000,
                'stock' => 30,
                'category_id' => $accessoires->id,
                'brand_id' => $maisonP2A->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Miroir Rond Doré',
                'description' => 'Miroir mural Ø80cm',
                'long_description' => 'Grand miroir rond avec cadre en métal doré. Parfait pour agrandir visuellement votre espace et ajouter une touche luxueuse.',
                'price' => 95000,
                'stock' => 12,
                'category_id' => $decoration->id,
                'brand_id' => $luxe->id,
                'is_active' => true,
            ],
            [
                'name' => 'Table Basse Marbre',
                'description' => 'Table basse plateau marbre blanc',
                'long_description' => 'Table basse élégante avec plateau en marbre blanc et pieds en métal noir. Design moderne et intemporel.',
                'price' => 185000,
                'sale_price' => 165000,
                'stock' => 8,
                'category_id' => $mobilier->id,
                'brand_id' => $luxe->id,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Tapis Berbère 200x300',
                'description' => 'Tapis tissé main motifs géométriques',
                'long_description' => 'Authentique tapis berbère tissé à la main. Motifs géométriques traditionnels. Laine naturelle de haute qualité.',
                'price' => 320000,
                'stock' => 5,
                'low_stock_alert' => 5,
                'category_id' => $textiles->id,
                'brand_id' => $maisonP2A->id,
                'is_active' => true,
            ],
            [
                'name' => 'Bougeoir Triple Bronze',
                'description' => 'Chandelier 3 branches',
                'long_description' => 'Élégant bougeoir en bronze antique à trois branches. Pièce décorative qui apportera une ambiance chaleureuse à votre intérieur.',
                'price' => 45000,
                'stock' => 20,
                'category_id' => $accessoires->id,
                'brand_id' => $luxe->id,
                'is_active' => true,
            ], */
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
