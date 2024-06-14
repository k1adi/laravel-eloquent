<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModelTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();

        $category->id = 'STATIONERY';
        $category->name = 'Office Stationery';
        $category->desc = 'Office Stationery Description';

        $result = $category->save();
        $this->assertTrue($result);
    }

    public function testInsertMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID - $i",
                'name' => "Name - $i"
            ];
        }

        // $result = Category::query()->insert($categories);
        $result = Category::insert($categories);
        $this->assertTrue($result);

        // $total = Category::query()->count()
        $total = Category::count();
        $this->assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        // $category = Category::query()->find();    
        $category = Category::find('FASHION');
        $this->assertNotNull($category);
        $this->assertEquals("FASHION", $category->id);    
        $this->assertEquals("Clothes", $category->name);    
        $this->assertEquals("Clothes Description", $category->desc);    
    }
}
