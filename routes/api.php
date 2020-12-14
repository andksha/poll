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

Route::group(['middleware' => 'api', 'prefix' => 'admin'], function () {
    Route::post('/poll', 'Admin\PollController@createPoll');
    Route::put('/poll/{id}', 'PollController@updatePoll');
    Route::delete('/poll/{id}', 'PollController@deletePoll');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
