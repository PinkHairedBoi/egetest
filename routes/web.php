<?php
Route::group(['middleware' => 'admin'], function() 
{
    Route::get('/admin', 'RouteController@admin')->where('any', '.*');
    Route::get('/admin/{any}', 'RouteController@admin')->where('any', '.*');
});
Route::group(['middleware' => 'auth'], function() 
{
    Route::get('/test', 'RouteController@test')->where('any', '.*');
    Route::get('/test/{any}', 'RouteController@test')->where('any', '.*');
});
Route::group(['middleware' => 'guest'], function ()
{
    Route::get('/{any}', 'RouteController@index')->where('any', '.*');
});