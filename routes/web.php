<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('telegram/get-me', 'BotController@getme');
Route::get('telegram/get-update', 'BotController@getupdate');
Route::get('telegram/reply-message', 'BotController@replyMessage');
Route::get('telegram/auto-responder', 'BotController@autoResponder');