<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'API'], function () {
        Route::apiResources([
            'api/chats' => 'Chat\ChatController',
            'api/chats/{chat}/messages' => 'Chat\ChatMessageController',
        ]);
    });

    Route::group(['namespace' => 'Chat', 'prefix' => 'chats'], function () {
        Route::get('/', 'ChatList');
        Route::get('/{id}', 'ChatItem');
    });
});
