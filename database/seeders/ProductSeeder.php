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
        // $product = new Product();
        // $product->id = 'SNACK';
        // $product->name = 'Snack';
        // $product->description = 'Snack Description';
        // $product->price = 1000;
        // $product->stock = 10;
        // $product->category_id = 'FOOD';
        // $product->save();

        Product::create([
            'id' => '1',
            'name' => 'Product 1',
            'description' => 'Product 1 Desc',
            'price' => 100,
            'stock' => 5,
            'category_id' => 'FOOD',
        ]);
        Product::create([
            'id' => '2',
            'name' => 'Product 2',
            'description' => 'Product 2 Desc',
            'price' => 500,
            'stock' => 10,
            'category_id' => 'FOOD',
        ]);
        Product::create([
            'id' => '3',
            'name' => 'Product 3',
            'description' => 'Product 3 Desc',
            'price' => 300,
            'stock' => 7,
            'category_id' => 'FOOD',
        ]);
    }
}
