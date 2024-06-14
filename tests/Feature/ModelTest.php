<?php

namespace Tests\Feature;

use App\Models\Category;
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
}
