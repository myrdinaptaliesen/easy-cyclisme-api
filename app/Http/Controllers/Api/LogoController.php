<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
// use File;
// use Response;

class LogoController extends Controller
{

  public function getLogo($filename) 
  { 

    $path = storage_path('app/public/uploads/'. $filename); 
    if (!File::exists($path)) { 
        abort(404); 
    } 

    $file = File::get($path); 
    $type = File::mimeType($path); 

    $response = Response::make($file, 200); 
    $response->header("Content-Type", $type); 
    return $response; 
  }	

}