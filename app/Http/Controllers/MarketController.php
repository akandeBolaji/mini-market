<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketRequest;
use App\Services\CreateMarketService;
use App\Services\GetMarketService;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function createMarket(MarketRequest $request)
    {
        $create = (new CreateMarketService())->run($request);
        return response()->json(200);
    }

    public function getAllMarkets()
    {
        $markets = (new GetMarketService())->run();
        return response()->json(['error' => false, 'data' => $markets]);
    }

    public function show(Market $market)
    {
        //
    }

    public function edit(Market $market)
    {
        //
    }

    public function update(Request $request, Market $market)
    {
        //
    }

    public function destroy(Market $market)
    {
        //
    }
}
