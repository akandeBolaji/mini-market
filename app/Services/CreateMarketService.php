<?php

namespace App\Services;

use App\Services\StoreImageService;
use App\Models\Market;
use Auth;
use DB;

class CreateMarketService
{
    public function run($request)
    {
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $title = $request->title;
            $body = $request->body;
            $images = $request->images;
            $market = Market::create([
                'title' => $title,
                'body' => $body,
                'user_id' => $user->id,
            ]);
            $storeImage = $this->storeImages($images, $market, $user);
            return $market;
        });
    }

    protected function storeImages($image, $market, $user)
    {
        foreach($images as $image) {
            (new StoreImageService())->run($image, $market, $user);
        }
    }
}
