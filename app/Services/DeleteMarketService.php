<?php

namespace App\Services;

use App\Models\Market;
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
