<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');

    Route::get('user', 'Api\UserController@user');

    Route::get('getDrawLotteries', 'Api\DrawLotteryController@getDrawLotteries');
    Route::get('getDraws', 'Api\DrawLotteryController@getDraws');
    Route::get('getDrawTickets', 'Api\DrawLotteryController@getDrawTickets');
    Route::post('setDrawTicket', 'Api\DrawLotteryController@setDrawTicket');
    Route::post('setDrawTickets', 'Api\DrawLotteryController@setDrawTickets');

    Route::get('getInstantLotteries', 'Api\InstantLotteryController@getInstantLotteries');
    Route::get('getSharedTickets', 'Api\InstantLotteryController@getSharedTickets');



    //Old
    Route::get('getActiveLotteriesWithEdition', 'Api\LotteryController@getActiveLotteriesWithEdition');
    Route::get('getActiveLotteries', 'Api\LotteryController@getActiveLotteries');
    
    Route::get('getTicketsWithEdition', 'Api\LotteryController@getTicketsWithEdition');
    Route::post('setTicketWithEdition', 'Api\LotteryController@setTicketWithEdition');
    Route::post('setTicketsWithEdition', 'Api\LotteryController@setTicketsWithEdition');

    Route::get('getTickets', 'Api\LotteryController@getTickets');
    Route::post('setTicket', 'Api\LotteryController@setTicket');

    Route::get('lotteryTypes', 'Api\LotteryTypeController@lotteryTypes');


});
