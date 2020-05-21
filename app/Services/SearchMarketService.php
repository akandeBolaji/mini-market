<?php

namespace App\Services;

use App\Models\Market;

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
            $markets = $this->getDistance($request->lat, $request->lng, $request->radius);
        }
        return $markets;
    }

    protected function filterMarket($field, $parameter)
    {
        return Market::with('images')->whereLike($field, $parameter)->orderBy('created_at', 'desc')->get();
    }

    protected function getDistance($latitude, $longitude, $radius)
    {
        $markets = Market::getNearBy($latitude, $longitude);
        return $markets;
    }

}
