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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::post('DataEventoResultadoEvento','Api\ApiController@EventoFecha');
Route::post('ConfirmacionToken','Api\ApiController@ConfirmacionToken');
//Route::post('DataEventoResultadoEventoFk','Api\ApiController@EventoFecha_outValidate');
Route::post('DataEventoResultadoEventoFk','Api\ApiController@EventoFecha');
