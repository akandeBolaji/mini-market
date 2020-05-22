<?php

namespace App\Services;

use App\Services\StoreImageService;
use App\Models\Market;
use App\Models\FoodCategory;
use Auth;
use DB;

class DeleteMarketService
{
    public function run($request)
    {
        DB::transaction(function () use ($request) {
            $market = Market::find($request->id)->delete();
            return true;
        });
    }
}
