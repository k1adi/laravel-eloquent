<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::where('customer_id', 'ADI')->firstOrFail();

        VirtualAccount::create([
            'bank' => 'BNI',
            'va_number' => '1234567890',
            'wallet_id' => $wallet->id
        ]);
    }
}
