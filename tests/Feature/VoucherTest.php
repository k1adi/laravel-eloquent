<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    public function testInsert()
    {
        $voucher = new Voucher();
        $voucher->name = 'Voucher Test';
        $voucher->voucher_code = '123456';
        $voucher->save();

        $this->assertNotNull($voucher->id);
    }

    public function testInsertMultiUUID()
    {
        $voucher = new Voucher();
        $voucher->name = 'Voucher Test';
        $voucher->save();

        $this->assertNotNull($voucher->id);
        $this->assertNotNull($voucher->voucher_code);
    }

    public function testSoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $this->assertNull($voucher);
    }

    public function testGetSoftDeleted()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', '=', 'Sample Voucher')->first();
        $voucher->delete();

        $voucher = Voucher::withTrashed()->where('name', '=', 'Sample Voucher')->first();
        $this->assertNotNull($voucher);
    }
    
    public function testLocalScope()
    {
        $voucher = new Voucher();
        $voucher->name = 'Voucher Test';
        $voucher->is_active = true;
        $voucher->save();

        $total = Voucher::query()->active()->count();
        $this->assertEquals(1, $total);

        $total = Voucher::query()->nonActive()->count();
        $this->assertEquals(0, $total);
    }
}
