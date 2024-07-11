<?php

namespace App\Models;

use App\Models\Scopes\CategoryIsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    // Added global scope
    protected static function booted(): void
    {
        parent::booted();
        self::addGlobalScope(new CategoryIsActiveScope());
    }

    // Allow mass assignment
    protected $fillable = [
        'id', 'name', 'desc'
    ];

    // Return all products that relation with this category
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    // Return one of data that matching with custom criteria
    public function cheapestProduct(): HasOne
    {
        // Get first index from row of data
        // return $this->hasOne(Product::class, 'category_id', 'id')->orderBy('price', 'asc');
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');
    }

    // Return one of data that matching with custom criteria
    public function expensiveProduct(): HasOne
    {
        // Get last index from row of data
        // return $this->hasOne(Product::class, 'category_id', 'id')->orderBy('price', 'desc');
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }
}
