<?php

Route::middleware('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')->prefix(LaravelLocalization::setLocale().'/bashkaruu')->group(function()
{
	Auth::routes();

	Route::name('logout')->get('/logout', 'Auth\LoginController@logout');

	Route::middleware('auth')->group(function () {
		Route::name('bashkaruu.index')->get('/', ['uses' => 'HomeController@index']);

		// users routes
		Route::resource('users', 'UserController');
		Route::name('users.delete')->get('users/delete/{user}', ['uses' => 'UserController@destroy']);

		// user types routes
		Route::resource('userTypes', 'UserTypeController');
		Route::name('userTypes.delete')->get('userTypes/delete/{userType}', ['uses' => 'UserTypeController@destroy']);

		// lottery types routes
		Route::resource('lotteryTypes', 'LotteryTypeController');
		Route::name('lotteryTypes.delete')->get('lotteryTypes/delete/{lotteryType}', ['uses' => 'LotteryTypeController@destroy']);

		// lottery editions routes
		Route::resource('lotteryEditions', 'LotteryEditionController');
		Route::name('lotteryEditions.delete')->get('lotteryEditions/delete/{lotteryEdition}', ['uses' => 'LotteryEditionController@destroy']);
	});

});

Route::post('getUsers', ['uses' => 'UserController@getUsers']);
Route::post('getUserTypes', ['uses' => 'UserTypeController@getUserTypes']);
Route::post('getLotteryTypes', ['uses' => 'LotteryTypeController@getLotteryTypes']);
Route::post('getLotteryEditions', ['uses' => 'LotteryEditionController@getLotteryEditions']);