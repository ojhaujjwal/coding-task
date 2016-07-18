<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'personal-details', 'as' => 'personal-details.'], function () {
    /*
     * Add New Personal Detail
     */
    Route::get('/create', 'PersonalDetailsController@create')
        ->name('create');

    Route::post('/create', 'PersonalDetailsController@store')
        ->name('store');

    Route::get('/{id}', 'PersonalDetailsController@showDetail')
        ->name('view');

    Route::get('/', 'PersonalDetailsController@listAll')
        ->name('list');
});
