<?php

namespace App\Http\Controllers\GetGuru;

use App\GetGuruConstants;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

class GetGuruController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['GetGetGuru', 'PostGetGuru']);
    }

    public function GetGetGuru(Request $request)
    {
        $client = new Client();
        try {
            $result = $client->get(GetGuruConstants::URL_API . $request->ns_method . '?' . $request->ns_params,
                [
                    'auth' =>  [GetGuruConstants::Username, GetGuruConstants::Password]
                ]);
        } catch (ClientException $e){
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(json_decode($responseBodyAsString), $response->getStatusCode());
        }

        return response()->json(json_decode($result->getBody()->getContents()), $result->getStatusCode());
    }

    public function PostGetGuru(Request $request)
    {
        return response()->json($request, 200);
    }
}
