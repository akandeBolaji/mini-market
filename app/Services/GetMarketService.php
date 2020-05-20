<?php

namespace App\Services;

use App\Models\Market;

class GetMarketService
{
    public function run()
    {
        $markets = Market::with('images')->orderBy('created_at', 'desc')->get();
        return $markets;
    }
    
}
