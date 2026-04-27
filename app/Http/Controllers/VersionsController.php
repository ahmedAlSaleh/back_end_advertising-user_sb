<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVersionRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class VersionsController extends Controller
{
    public function index()
    {
        $version = Setting::first();
        return response()->json([
            'status' => true,
            'data' => $version
        ]);
    }

    public function update(UpdateVersionRequest $request)
    {

        $version = Setting::first();
        if($version){
            $version->update($request->all());
        }else{
            $version = Setting::create($request->all());
        }
        return response()->json([
            'status' => true,
            'data' => $version
        ]);
    }
}
