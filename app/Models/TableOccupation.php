<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TableOccupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
        'table_id',
        'guest_id',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function guest(): HasOne
    {
        return $this->hasOne(TableGuest::class);
    }
}
