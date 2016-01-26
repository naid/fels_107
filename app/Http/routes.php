<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth.admin'], function () {
    Route::resource('categories', 'CategoryController');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('categories', 'CategoryController', ['only' => ['index']]);
    Route::get('/', ['as' => 'home', 'uses' => 'UserController@index']);
    Route::get('/home', ['as' => 'home', 'uses' => 'UserController@index']);

    Route::get('/change-password', ['as' => 'users.change.password', 'uses' => 'UserController@changePassword']);
    Route::patch('/update-password', ['as' => 'users.update.password', 'uses' => 'UserController@updatePassword']);

    Route::resource('users', 'UserController');
});
