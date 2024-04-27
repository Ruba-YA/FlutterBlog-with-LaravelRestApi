<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

abstract class Controller
{
    public function saveImage($image , $path = 'public')
    {
        if(!$image)
        {
            return null;
        }

        $fileName = time().'.png';
        // save image 
        Storage::disk($path)->put($fileName, base64_decode($image));

        //return the path

        return URL::to('/').'/storage/'.$path.'/'. $fileName;
    }
}
