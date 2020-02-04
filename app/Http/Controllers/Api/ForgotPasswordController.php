<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param  string  $response
     * @return ResponseFactory|Response
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message' => trans($response)]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param  string  $response
     * @return ResponseFactory|Response
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['error' => trans($response)], 422);
    }

}
