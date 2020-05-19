<?php

namespace App\Services;

use App\Models\Image;
use Storage;

class StoreImageService
{
    public function run($image, $market, $user)
    {
        $imagePath = Storage::disk('uploads')->put($user->email . '/markets/' . $market->id, $image);
        $image = Image::create([
            'url' => '/uploads/' . $imagePath,
            'market_id' => $post->id
        ]);
        return $image;
    }
}
