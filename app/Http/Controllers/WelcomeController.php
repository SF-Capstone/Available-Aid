<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class WelcomeController extends Controller
{
    public function show() {
        return view('welcome');
    }

    public function hasImage($imageName) {
        $allImages = Storage::files('public/images/');
        $image = preg_grep('/' . $imageName . '.*/', $allImages);
        return count($image) > 0;
    }

    public function getImage($imageName) {
        $imageName = strtr($imageName, array('(' => '', ')' => '')); // strip out parentheses
        $allImages = Storage::files('public/images/');
        $image = preg_grep('/' . $imageName . '.*/', $allImages);
        
        $imagePath = reset($image);
        $pathInfo = pathinfo($imagePath);

        $imageData = Storage::get($imagePath);
        
        header("Content-type: image/" . $pathInfo["extension"]);
        header("Content-Length: " . strlen($imageData));

        echo $imageData;
    }
}
