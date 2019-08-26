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

/**
 * Events
 */
Route::apiResource('users', 'User\UserController');
Route::apiResource('events', 'Event\EventController');
Route::apiResource('event_schedules', 'Event\EventScheduleController');
Route::get('public/event_schedules', 'Event\EventScheduleController@publicIndex');
Route::apiResource('locations', 'Location\LocationController');

Route::apiResource('lodgings', 'Lodging\LodgingController');
Route::get('user', 'User\UserController@userInfo');

Route::apiResource('new_versions', 'Version\NewVersionController');
Route::get('public/new_versions', 'Version\NewVersionController@publicIndex');
Route::get('public/new_versions/current_version', 'Version\NewVersionController@showCurrentVersion');

Route::apiResource('update_versions', 'Version\UpdateVersionController');
Route::get('public/update_versions', 'Version\UpdateVersionController@publicIndex');
Route::get('public/update_versions/current_version', 'Version\UpdateVersionController@showCurrentVersion');

Route::apiResource('webinars', 'Webinar\WebinarController');
Route::get('public/webinars', 'Webinar\WebinarController@publicIndex');

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
