<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url', 'market_id'
    ];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
