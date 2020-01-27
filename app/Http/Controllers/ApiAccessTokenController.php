<?php


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class ApiAccessTokenController extends AccessTokenController
{
    /**
     * Authorize a client to access the user's account.
     *
     * @param  ServerRequestInterface  $request
     * @return Response
     */
    public function issueToken(ServerRequestInterface $request)
    {
        //$validatedData = request()->validate($rules);

        $user = User::where('enable', 1)
            ->where('username', request()->username)
            ->first();

        if (!$user) {
            return response()->json(['mensaje' => 'Usuario inactivo'] , 200);
        }

        return $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }
}
