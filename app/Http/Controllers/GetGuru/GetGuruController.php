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
        $this->middleware('auth:api')->except(['GetGetGuru', 'PostGetGuru', 'RequestGetGuru']);
    }

    public function RequestGetGuru(Request $request)
    {
        if($request->ps_type == 'POST'){
            return $this->PostGetGuru($request);
        } else if ($request->ps_type == 'GET'){
            return $this->GetGetGuru($request);
        }
        return response()->json(['message' => 'A request method is not supported for the requested resource'],405);
    }

    public function GetGetGuru(Request $request)
    {
        $client = new Client();
        try {
            $result = $client->get(GetGuruConstants::URL_API . $request->ps_method . '?' . $request->ps_params,
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
        $client = new Client();
        try {
            $result = $client->post(GetGuruConstants::URL_API . $request->ps_method,
                [
                    'auth' =>  [ GetGuruConstants::Username, GetGuruConstants::Password ],
                    'headers' => ['Content-Type'     => 'application/json'],
                    'body' => json_encode($request->ps_body)
                ]);
        } catch (ClientException $e){
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return response()->json(json_decode($responseBodyAsString), $response->getStatusCode());
        }

        return response()->json(json_decode($result->getBody()->getContents()), $result->getStatusCode());
    }
}
