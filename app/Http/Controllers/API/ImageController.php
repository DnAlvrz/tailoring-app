<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // save images
    public function store(Request  $request) {
        Log::info($request->all());
        $path = storage_path('app/public/products/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        Log::info($path);
        $file = $request->file('image');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return ['name' => $name];
    }

}
