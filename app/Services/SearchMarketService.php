<?php

namespace App\Services;

use App\Models\Market;

class SearchMarketService
{
    public function run($request)
    {
        if ($request->type == 'Name')
        {
            $markets = $this->filterMarket('name', $request->search);
        }
        else if ($request->type == 'Category')
        {
            $markets = $this->filterMarket('category', $request->search);
        }
        else
        {

        }
        return $markets;
    }

    protected function filterMarket($field, $parameter)
    {
        return Market::with('images')->where($field, $parameter)->orderBy('created_at', 'desc')->get();
    }

}
