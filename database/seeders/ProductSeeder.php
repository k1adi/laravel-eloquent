<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->id = 'SNACK';
        $product->name = 'Snack';
        $product->description = 'Snack Description';
        $product->price = 1000;
        $product->stock = 10;
        $product->category_id = 'FOOD';
        $product->save();
    }
}
