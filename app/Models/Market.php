<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public static function getNearBy($lat, $lng, $distance = 500, $distanceIn = 'km')
    {
    if ($distanceIn == 'km') {
    $results = self::with('images')->select(['*', DB::raw('( 0.621371 * 3959 * acos( cos( radians('.$lat.') ) * cos( radians( address_latitude ) ) * cos( radians( address_longitude ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(address_latitude) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->orderBy("distance")->get();
    } else {
    $results = self::select(['*', DB::raw('( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(lat) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->get();
    }
    return $results;
    }
}
