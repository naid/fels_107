<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth.admin'], function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('words', 'WordController');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('categories', 'CategoryController', ['only' => ['index']]);
    Route::resource('words', 'WordController', ['only' => ['index']]);
    Route::get('/', ['as' => 'home', 'uses' => 'UserController@index']);
    Route::get('/home', ['as' => 'home', 'uses' => 'UserController@index']);
});
