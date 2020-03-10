<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::apiResource('users', 'User\UserController');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware('decrypt');

Route::post('users', 'User\UserController@store');
Route::put('users/{username}', 'User\UserController@update');
Route::get('users', 'User\UserController@index');
Route::get('users/{username}', 'User\UserController@show');
Route::delete('users/{username}', 'User\UserController@destroy');

Route::get('me', 'User\UserController@userInfo');
Route::put('users/password/reset', 'User\UserController@passwordReset');
Route::put('users/password/change', 'User\UserController@passwordChange');
Route::get('users/{username}/exist', 'User\UserController@userExist');

Route::get('decrypt', 'User\UserController@decrypt');

Route::apiResource('events', 'Event\EventController');

Route::apiResource('event_schedules', 'Event\EventScheduleController');
Route::get('public/event_schedules', 'Event\EventScheduleController@publicIndex');

Route::apiResource('locations', 'Location\LocationController');
Route::apiResource('lodgings', 'Lodging\LodgingController');

Route::apiResource('new_versions', 'Version\NewVersionController');
Route::get('public/new_versions', 'Version\NewVersionController@publicIndex');
Route::get('public/new_versions/current_version', 'Version\NewVersionController@showCurrentVersion');

Route::apiResource('update_versions', 'Version\UpdateVersionController');
Route::get('public/update_versions', 'Version\UpdateVersionController@publicIndex');
Route::get('public/update_versions/current_version', 'Version\UpdateVersionController@showCurrentVersion');

Route::apiResource('webinars', 'Webinar\WebinarController');
Route::get('public/webinars', 'Webinar\WebinarController@publicIndex');

Route::post('public/get-guru', 'GetGuru\GetGuruController@RequestGetGuru');

Route::post('password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Api\ResetPasswordController@reset');

Route::get('crm/ticket/issues', 'CRMTicket\CRMTicketController@getIssues');
Route::post('crm/ticket', 'CRMTicket\CRMTicketController@newWebTicket');

Route::post('email/feature_request', 'Email\EmailController@sendEmailFeatureRequest');
Route::post('email/contact_us', 'Email\EmailController@sendEmailContactUs');
Route::post('email/request_more_info', 'Email\EmailController@sendEmailRequestMoreInfo');
