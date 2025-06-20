<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TableOccupation extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(TableGuest::class);
    }
}
