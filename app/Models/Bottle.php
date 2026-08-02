<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bottle extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'img_src'];

    public function filledBottles(): HasMany
    {
        return $this->hasMany(FilledBottle::class);
    }
}
