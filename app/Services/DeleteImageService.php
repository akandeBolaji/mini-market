<?php

namespace App\Services;

use App\Models\Image;
use DB;

class DeleteImageService
{
    public function run($request)
    {
        DB::transaction(function () use ($request) {
            $image = Image::find($request->id)->delete();
            return true;
        });
    }
}
