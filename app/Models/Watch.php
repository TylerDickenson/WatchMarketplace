<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    protected $guarded = [];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    } 
}
