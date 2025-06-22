<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'menu_number',
        'description',
        'is_side_dish'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // make sure is_side_dish is a boolean
    protected $casts = [
        'is_side_dish' => 'boolean',
    ];
}
