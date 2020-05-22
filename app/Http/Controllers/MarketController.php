<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketRequest;
use App\Http\Requests\SearchMarketRequest;
use App\Http\Requests\UpdateMarketRequest;
use App\Http\Requests\DeleteMarketRequest;
use App\Services\CreateMarketService;
use App\Services\GetMarketService;
use App\Services\SearchMarketService;
use App\Services\UpdateMarketService;
use App\Services\DeleteMarketService;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function createMarket(MarketRequest $request)
    {
        $create = (new CreateMarketService())->run($request);
        return response()->json(200);
    }

    public function updateMarket(UpdateMarketRequest $request)
    {
        $create = (new UpdateMarketService())->run($request);
        return response()->json(200);
    }

    public function getAllMarkets()
    {
        $markets = (new GetMarketService())->run();
        return response()->json(['error' => false, 'data' => $markets]);
    }

    public function searchMarket(SearchMarketRequest $request)
    {
        $markets = (new SearchMarketService())->run($request);
        return response()->json(['error' => false, 'data' => $markets]);
    }

    public function deleteMarket(DeleteMarketRequest $request)
    {
        $create = (new DeleteMarketService())->run($request);
        return response()->json(200);
    }
}
