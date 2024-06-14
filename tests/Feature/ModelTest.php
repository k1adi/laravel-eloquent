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

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FASHION');
        $category->name = 'Pants';
        $category->desc = 'Pant Description';

        $result = $category->update();
        $this->assertTrue($result);
    }

    public function testSelect()
    {
        for($i=0; $i < 5; $i++){
            $category = new Category();
            $category->id = "ID - $i";
            $category->name = "Name - $i";
            $category->save();
        }

        // $categories = Category::query()->whereNull('desc')->get();
        $categories = Category::whereNull('desc')->get();
        $this->assertEquals(5, $categories->count());

        $categories->each(function ($category) {
            $category->desc = 'Updated';
            $category->update();
        });

        $categories = Category::whereNull('desc')->get();
        $this->assertEquals(0, $categories->count());
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID - $i",
                'name' => "Name - $i"
            ];
        }

        $result = Category::insert($categories);
        $this->assertTrue($result);

        Category::whereNull('desc')->update([
            'desc' => 'Updated'
        ]);

        $total = Category::where('desc', 'Updated')->count();
        $this->assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FASHION');
        $result = $category->delete();
        $this->assertTrue($result);

        $total = Category::count();
        $this->assertEquals(0, $total);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID - $i",
                'name' => "Name - $i"
            ];
        }

        $result = Category::insert($categories);
        $this->assertTrue($result);

        $total = Category::count();
        $this->assertEquals(10, $total);

        Category::whereNull('desc')->delete();
        $total = Category::count();
        $this->assertEquals(0, $total);
    }
}
