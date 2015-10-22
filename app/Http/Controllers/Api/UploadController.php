<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    
    public function uploadpcount(Request $request)
    {
        $destinationPath = storage_path().'/uploads/pcount/';
        $fileName = $request->file('data')->getClientOriginalName();
        $request->file('data')->move($destinationPath, $fileName);
    }

}
