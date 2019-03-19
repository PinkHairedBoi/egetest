<?php
Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::post('/login', "Auth\LoginController@login");
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/user', 'UserController@me');
        Route::get('/get', 'QuestionController@get');
        Route::post('/answer', 'QuestionController@answer');
        Route::get('/logout', 'Auth\LoginController@logout');
    });

    Route::group(['middleware' => 'admin'], function () {

        Route::resource('/tests', 'TestController')->except('create', 'edit');
        Route::get('/getTests', 'TestController@getTests');
        Route::resource('/questions', 'QuestionController')->except('create', 'edit');
        Route::post('/getQuestions', 'QuestionController@getQuestions');
        Route::post('/getRawQuestions', 'QuestionController@getRawQuestions');
        Route::resource('/users', 'UserController')->except('create', 'edit');
        Route::get('/getUsers', 'UserController@getUsers');
        Route::post('/getAttempts', 'AnswerController@getAttempts');
        Route::post('/getAnswers', 'AnswerController@getAnswers');

        Route::post('/questions/copy', 'QuestionController@copy');
        Route::post('/tests/move', 'TestController@move');
        Route::get('/answers', 'AnswerController@index');
        Route::get('/tests/byOrder/{order}', 'TestController@showByOrder');
        Route::get('/images/{id}', 'QuestionController@removeImage');

    });
});
