<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/postalmate', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/flex', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/support', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/downloads', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/adminmenu', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/adminmenu/event', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/adminmenu/event/schedules', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/adminmenu/downloads', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/adminmenu/uploads', function () {
    View::addExtension('html','php');
    return View::make('index');
});

Route::get('/login', function () {
    View::addExtension('html','php');
    return View::make('index');
});
