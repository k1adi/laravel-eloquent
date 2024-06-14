<?php

namespace Tests\Feature;

use App\Models\Voucher;
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
}
