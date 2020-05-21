<?php

namespace App\Services;

use App\Services\StoreImageService;
use App\Models\Market;
use App\Models\FoodCategory;
use Auth;
use DB;

class UpdateMarketService
{
    public function run($request)
    {
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $category = FoodCategory::firstOrCreate(['name' => $request->category]);
            $name = $request->name;
            $description = $request->description;
            $address = $request->address;
            $address_lat = $request->address_lat;
            $address_long = $request->address_long;
            $images = $request->images;
            $market = Market::find($request->id)->update([
                'name' => $name,
                'description' => $description,
                'category' => $category->name,
                'category_id' => $category->id,
                'address_address' => $address,
                'address_latitude' => $address_lat,
                'address_longitude' => $address_long
            ]);
            if ($images && $images->length > 0)
            {
                $storeImage = $this->storeImages($images, $market->id, $user->email);
            }
            return $market;
        });
    }

    protected function storeImages($images, $market_id, $user_email)
    {
        foreach($images as $image) {
            (new StoreImageService())->run($image, $market_id, $user_email);
        }
    }
}
