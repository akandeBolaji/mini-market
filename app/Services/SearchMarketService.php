<?php

namespace App\Services;

use App\Models\Market;
use DB;

class SearchMarketService
{
    public function run($request)
    {
        if ($request->type == 'Name')
        {
            $markets = $this->filterMarket(['name'], $request->search);
        }
        else if ($request->type == 'Category')
        {
            $markets = $this->filterMarket(['category'], $request->search);
        }
        else
        {
            $markets = $this->getDistance($request->lat, $request->lng);
        }
        return $markets;
    }

    protected function filterMarket($field, $parameter)
    {
        return Market::with('images')->whereLike($field, $parameter)->orderBy('created_at', 'desc')->get();
    }

    protected function getDistance($latitude, $longitude)
    {
        $markets = Market::select(['*', DB::raw('( 0.621371 * 3959 * acos( cos( radians('.$latitude.') ) * cos( radians( address_latitude ) ) * cos( radians( address_longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians(address_latitude) ) ) ) AS distance')])->orderBy("distance")->with('images')->get();
        //$markets = Market::getNearBy($latitude, $longitude, $radius);
        return $markets;
    }

}
