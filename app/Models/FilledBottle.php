<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilledBottle extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'bottle_id', 'beverage_id'];

    public function bottle(): BelongsTo
    {
        return $this->belongsTo(Bottle::class);
    }

    public function beverage(): BelongsTo
    {
        return $this->belongsTo(Beverage::class);
    }
}
