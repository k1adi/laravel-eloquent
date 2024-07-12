<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create([
            'product_id' => '1',
            'customer_id' => 'ADI',
            'rating' => 6,
            'comment' => 'Mantap jos gandos'
        ]);

        Review::create([
            'product_id' => '3',
            'customer_id' => 'ADI',
            'rating' => 3,
            'comment' => 'Meehhhhh...'
        ]);
    }
}
