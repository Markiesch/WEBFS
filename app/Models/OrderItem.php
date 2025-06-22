<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'dish_id',
        'side_dish_id',
        'quantity',
        'price',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function sideDish()
    {
        return $this->belongsTo(Dish::class, 'side_dish_id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }
}
