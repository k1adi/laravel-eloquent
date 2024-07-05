<?php

namespace App\Models;

use App\Models\Scopes\CategoryIsActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
