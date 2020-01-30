<?php

namespace App\Http\Controllers\GetGuru;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class GetGuruController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['GetGetGuru', 'PostGetGuru']);
    }

    public function GetGetGuru(Request $request)
    {
        return response()->json($request, 200);
    }

    public function PostGetGuru(Request $request)
    {
        return response()->json($request, 200);
    }
}
