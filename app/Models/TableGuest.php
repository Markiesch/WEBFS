<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TableGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'birthdate',
        'has_deluxe_menu',
    ];

    public function tableOccupation(): BelongsTo
    {
        return $this->belongsTo(TableOccupation::class);
    }
}
