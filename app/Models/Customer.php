<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string'; // Also corrected a typo here ('sring' to 'string')
    public $incrementing = false;  // Change visibility to public
    public $timestamps = false;

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }
}
