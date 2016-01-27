<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth.admin'], function () {
    Route::resource('categories', 'CategoryController');
    Route::resource('words', 'WordController');
    Route::resource('lessons', 'LessonController');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('categories', 'CategoryController', ['only' => ['index']]);
    Route::resource('words', 'WordController', ['only' => ['index']]);
    Route::resource('lessons', 'LessonController');
    Route::resource('lesson_words', 'LessonWordController');
    Route::get('/exam', [
        'as' => 'exam',
        'uses' => 'LessonWordController@index',
    ]);
    Route::post('/exam', [
        'as' => 'exam',
        'uses' => 'LessonWordController@update',
    ]);
    Route::get('/result/{id}', 'LessonWordController@show');

    Route::get('/', ['as' => 'home', 'uses' => 'UserController@index']);
    Route::get('/home', ['as' => 'home', 'uses' => 'UserController@index']);
});
