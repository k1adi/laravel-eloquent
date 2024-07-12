<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);
        
        $customer = Customer::find('ADI');
        $this->assertNotNull($customer);

        $wallet = $customer->wallet;
        $this->assertNotNull($wallet);
        $this->assertEquals(100000, $wallet->amount);
    }

    public function testOneToOneInsert()
    {
        $customer = new Customer();
        $customer->id = 'RIZKI';
        $customer->name = 'Kiadi';
        $customer->email = 'kiadi@email.com';
        $customer->save();
        $this->assertNotNull($customer);

        $wallet = new Wallet();
        $wallet->amount = 20000;
        // Insert new data with relation / current customer->id
        // Without writing customer->id 
        $customer->wallet()->save($wallet);

        $kiadi = Customer::find('RIZKI');
        $kiadi_wallet = $kiadi->wallet;
        $this->assertEquals(20000, $kiadi_wallet->amount);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find('ADI');
        $this->assertNotNull($customer);

        $vaAccount = $customer->virtualAccount;
        $this->assertNotNull($vaAccount);
        $this->assertEquals('BNI', $vaAccount->bank);
    }

    public function testInsertManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find('ADI');
        $this->assertNotNull($customer);

        $customer->likeProducts()->attach('1'); // attach product_id
        $customer->likeProducts()->attach('2'); // attach product_id

        $products = $customer->likeProducts;
        Log::info($products);
        $this->assertCount(2, $products);
    }

    public function testRemoveManyToMany()
    {
        $this->testInsertManyToMany();

        $customer = Customer::find('ADI');
        $customer->likeProducts()->detach('1');

        $products = $customer->likeProducts;
        $this->assertNotNull($products);
        $this->assertCount(1, $products);
    }
}
