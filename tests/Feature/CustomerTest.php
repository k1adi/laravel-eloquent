<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
