<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1, // Frutas
                'name' => 'Manzana',
                'brand' => 'Marca A',
                'weight' => '1 kg',
                'purchase_price' => 1.50,
                'sale_price' => 2.00,
                'stock' => 10,
            ],
            [
                'category_id' => 2, // Verduras
                'name' => 'Zanahoria',
                'brand' => 'Marca B',
                'weight' => '1 kg',
                'purchase_price' => 0.80,
                'sale_price' => 1.20,
                'stock' => 15,
            ],
            [
                'category_id' => 3, // Enlatados
                'name' => 'Atún enlatado',
                'brand' => 'Marca C',
                'weight' => '150 g',
                'purchase_price' => 1.00,
                'sale_price' => 1.50,
                'stock' => 20,
            ],
            [
                'category_id' => 4, // Lácteos
                'name' => 'Leche',
                'brand' => 'Marca D',
                'weight' => '1 litro',
                'purchase_price' => 2.50,
                'sale_price' => 3.50,
                'stock' => 8,
            ],
            [
                'category_id' => 5, // Carnes
                'name' => 'Filete de pollo',
                'brand' => 'Marca E',
                'weight' => '500 g',
                'purchase_price' => 3.00,
                'sale_price' => 4.50,
                'stock' => 12,
            ],
            [
                'category_id' => 6, // Bebidas
                'name' => 'Refresco de cola',
                'brand' => 'Marca F',
                'weight' => '2 litros',
                'purchase_price' => 1.80,
                'sale_price' => 2.50,
                'stock' => 18,
            ],
            [
                'category_id' => 4, // Lácteos
                'name' => 'Yogur',
                'brand' => 'Marca G',
                'weight' => '200 g',
                'purchase_price' => 0.75,
                'sale_price' => 1.20,
                'stock' => 15,
            ],
            [
                'category_id' => 5, // Carnes
                'name' => 'Bistec de res',
                'brand' => 'Marca H',
                'weight' => '300 g',
                'purchase_price' => 5.50,
                'sale_price' => 8.00,
                'stock' => 10,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}
