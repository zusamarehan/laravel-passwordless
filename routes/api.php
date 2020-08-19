<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'LoginRequestController')->name('login.request');
Route::middleware('fresh.cookies')->get('loginwithemail', 'LoginAuthenticateController')->name('login.authenticate.email');

Route::middleware('pudding.auth')->get('/user', function (Request $request) {
    return $request->user();
});
