<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Attribut Couleur
        $colorAttr = ProductAttribute::create([
            'name' => 'Couleur',
            'code' => 'color',
            'type' => 'color',
            'sort_order' => 1,
        ]);

        $colors = [
            ['value' => 'Rouge', 'code' => 'red', 'color_hex' => '#FF0000'],
            ['value' => 'Bleu', 'code' => 'blue', 'color_hex' => '#0000FF'],
            ['value' => 'Vert', 'code' => 'green', 'color_hex' => '#00FF00'],
            ['value' => 'Noir', 'code' => 'black', 'color_hex' => '#000000'],
            ['value' => 'Blanc', 'code' => 'white', 'color_hex' => '#FFFFFF'],
            ['value' => 'Jaune', 'code' => 'yellow', 'color_hex' => '#FFFF00'],
            ['value' => 'Orange', 'code' => 'orange', 'color_hex' => '#FFA500'],
            ['value' => 'Rose', 'code' => 'pink', 'color_hex' => '#FFC0CB'],
            ['value' => 'Violet', 'code' => 'purple', 'color_hex' => '#800080'],
            ['value' => 'Gris', 'code' => 'gray', 'color_hex' => '#808080'],
        ];

        foreach ($colors as $index => $color) {
            ProductAttributeValue::create([
                'product_attribute_id' => $colorAttr->id,
                'value' => $color['value'],
                'code' => $color['code'],
                'color_hex' => $color['color_hex'],
                'sort_order' => $index + 1,
            ]);
        }

        // Attribut Taille
        $sizeAttr = ProductAttribute::create([
            'name' => 'Taille',
            'code' => 'size',
            'type' => 'select',
            'sort_order' => 2,
        ]);

        $sizes = [
            ['value' => 'XS', 'code' => 'xs'],
            ['value' => 'S', 'code' => 's'],
            ['value' => 'M', 'code' => 'm'],
            ['value' => 'L', 'code' => 'l'],
            ['value' => 'XL', 'code' => 'xl'],
            ['value' => 'XXL', 'code' => 'xxl'],
        ];

        foreach ($sizes as $index => $size) {
            ProductAttributeValue::create([
                'product_attribute_id' => $sizeAttr->id,
                'value' => $size['value'],
                'code' => $size['code'],
                'sort_order' => $index + 1,
            ]);
        }

        // Attribut Matériau
        $materialAttr = ProductAttribute::create([
            'name' => 'Matériau',
            'code' => 'material',
            'type' => 'select',
            'sort_order' => 3,
        ]);

        $materials = [
            ['value' => 'Coton', 'code' => 'cotton'],
            ['value' => 'Lin', 'code' => 'linen'],
            ['value' => 'Polyester', 'code' => 'polyester'],
            ['value' => 'Laine', 'code' => 'wool'],
            ['value' => 'Soie', 'code' => 'silk'],
            ['value' => 'Cuir', 'code' => 'leather'],
        ];

        foreach ($materials as $index => $material) {
            ProductAttributeValue::create([
                'product_attribute_id' => $materialAttr->id,
                'value' => $material['value'],
                'code' => $material['code'],
                'sort_order' => $index + 1,
            ]);
        }
    }
}
