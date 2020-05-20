<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'category',
        'description',
        'address_address',
        'address_latitude',
        'address_longitude'
    ];

    public function images()
	{
		return $this->hasMany(Image::class);
    }

    public function category()
	{
		return $this->belongsTo(Category::class);
    }
}
