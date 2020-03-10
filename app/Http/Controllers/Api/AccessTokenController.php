<?php

namespace App\Http\Controllers\API;

use App\User;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

// Completely overrides Laravel\Passport\Http\Controllers\AccessTokenController
class AccessTokenController extends APIController
{
    /**
     * Authorize a client to access the user's account.
     *
     * @param  ServerRequestInterface  $request
     * @return Illuminate\Http\Response
     */
    public function attemptLogin(ServerRequestInterface $request)
    {
        
        return $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }
}