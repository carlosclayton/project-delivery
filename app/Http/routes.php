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



Route::get('/test', function(){
   $repository = app()->make('Delivery\Repositories\CategoryRepository');
   return $repository->all();
});


Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::get('login', function () {
            return view('auth.login');
        });

        Route::get('register', function () {
            return view('auth.login');
        });

    });



});




Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CategoriesController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'CategoriesController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'CategoriesController@store']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CategoriesController@edit']);
    });
});