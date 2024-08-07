<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Scopes\CategoryIsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
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

    public function testCreate()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'Ramen',
            'desc' => 'Ramen Desc'
        ];

        $category = new Category($request);
        $category->save();

        $this->assertNotNull($category->id);
    }

    public function testCreateBuilder()
    {
        $request = [
            'id' => 'FOOD',
            'name' => 'Ramen',
            'desc' => 'Ramen Desc'
        ];

        // $category = Category::query()->create($request);
        $category = Category::create($request);
        $this->assertNotNull($category->id);
    }

    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('FASHION');
        $request = [
            'name' => 'Fashion Updated',
            'desc' => 'Fashion Food Updated'
        ];

        $category->fill($request);
        $category->save();

        $this->assertNotNull($category->id);
    }

    public function testGlobalScope()
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->desc = 'Food Category';
        $category->is_active = false;
        $category->save();

        $category = Category::find('FOOD');
        $this->assertNull($category);
    }

    public function testWithoutGlobalScope()
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->desc = 'Food Category';
        $category->is_active = false;
        $category->save();

        $category = Category::withoutGlobalScopes([CategoryIsActiveScope::class])->find('FOOD');
        $this->assertNotNull($category);
    }
    
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');
        $this->assertNotNull($category);

        $products = $category->products;
        $this->assertNotNull($products);
        $this->assertCount(1, $products);
    }

    public function testOneToManyInsert(){
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->desc = 'Food Desc';
        $category->is_active = true;
        $category->save();
        $this->assertNotNull($category);

        $product = new Product();
        $product->id = 'SNACK';
        $product->name = 'Snack';
        $product->description = 'Snack Description';
        $category->products()->save($product);
        $this->assertNotNull($product);
    }

    public function testRelationSearch()
    {
        $this->testOneToManyInsert();

        $category = Category::find('FOOD');
        $outOfStock = $category->products()->where('stock', '<=', 0)->get();
        $this->assertNotNull($outOfStock);
        $this->assertEquals(1, $outOfStock->count());
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');

        $cheapestProduct = $category->cheapestProduct;
        $this->assertNotNull($cheapestProduct);
        $this->assertEquals('1', $cheapestProduct->id);

        $expensiveProduct = $category->expensiveProduct;
        $this->assertNotNull($expensiveProduct);
        $this->assertEquals('2', $expensiveProduct->id);
        Log::info(json_encode([
            'cheap' => $cheapestProduct,
            'expensive' => $expensiveProduct
        ]));
    }

    public function testHasManyThrough()
    {
        $this->seed([
            CategorySeeder::class, 
            ProductSeeder::class, 
            CustomerSeeder::class, 
            ReviewSeeder::class
        ]);

        $category = Category::find('FOOD');
        $this->assertNotNull($category);

        $reviews = $category->reviews;
        Log::info($reviews);
        $this->assertNotNull($reviews);
        $this->assertEquals(2, $reviews->count());
    }
}
