<?php
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


Route::group(['prefix' => '/api/v1/DDIS/lang/',
    'namespace' => 'DDIS\lang\app\Http\Controllers\API',
    'middleware'=>['Cors', 'Json']], function () {


        Route::get('form/{id}', 'FormController@get');
        Route::get('forms', 'FormController@getAll');
        Route::post('form', 'FormController@set');
        Route::put('form/{id}', 'FormController@update');
        Route::delete('form/{id}', 'FormController@delete');

        Route::get('form/sentences/{id}', 'SentenceController@getByForm');
        Route::get('sentence/{id}', 'SentenceController@get');
        Route::get('sentence/slug/{id}', 'SentenceController@getBySlug');
        Route::get('sentences', 'SentenceController@getAll');
        Route::post('sentence', 'SentenceController@set');
        Route::put('sentence/{id}', 'SentenceController@update');
        Route::delete('sentence/{id}', 'SentenceController@delete');


});
