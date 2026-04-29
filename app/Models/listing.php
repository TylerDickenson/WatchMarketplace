<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{

    protected $fillable = [
        'seller_id', 
        'watch_id', 
        'price', 
        'condition', 
        'location', 
        'seller_notes', 
        'is_active'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function watch()
    {
        return $this->belongsTo(Watch::class, 'watch_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }
}
