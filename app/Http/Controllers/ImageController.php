<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\ImageDeleteRequest;
use App\Services\DeleteImageService;

class ImageController extends Controller
{
    public function deleteImage(ImageDeleteRequest $request)
    {
        $create = (new DeleteImageService())->run($request);
        return response()->json(200);
    }
}
