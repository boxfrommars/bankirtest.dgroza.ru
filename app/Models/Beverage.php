<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beverage extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description'];

    public function filledBottles(): HasMany
    {
        return $this->hasMany(FilledBottle::class);
    }
}
