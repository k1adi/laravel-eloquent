<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    public function virtualAccount(): HasOneThrough
    {
        // Customer table have relation one to one on virtual_account table
        // through wallet table
        return $this->hasOneThrough(VirtualAccount::class, Wallet::class, 
            'customer_id', // Foreign key on wallet table
            'wallet_id', // Foreign key on virtual_account table
            'id', // Primary key on customer table
            'id' // Primary key on wallet table
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'customer_id', 'id');
    }
}
