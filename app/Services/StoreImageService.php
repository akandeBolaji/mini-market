<?php

namespace App\Services;

use App\Models\Image;
use Storage;

class StoreImageService
{
    public function run($image, $market_id, $user_email)
    {
        $imagePath = Storage::disk('uploads')->put($user_email . '/markets/' . $market_id, $image);
        $image_create = Image::create([
            'url' => '/uploads/' . $imagePath,
            'market_id' => $market_id
        ]);
        return $image_create;
    }
}
