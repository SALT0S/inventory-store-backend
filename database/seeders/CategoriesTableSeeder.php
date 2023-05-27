<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Frutas'],
            ['name' => 'Verduras'],
            ['name' => 'Enlatados'],
            ['name' => 'Lácteos'],
            ['name' => 'Carnes'],
            ['name' => 'Bebidas'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }

    }
}
