<?php

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::middleware('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')->prefix(LaravelLocalization::setLocale().'/admin')->group(function () {

    Auth::routes();

	Route::name('logout')->get('/logout', 'Auth\LoginController@logout');

    Route::middleware('auth')->group(function () {
    	Route::name('admin.index')->get('/', ['uses' => 'HomeController@index']);

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

		// lottery edition tickets routes
		Route::resource('lotteryEditions/{lotteryEdition}/lotteryEditionTickets', 'LotteryEditionTicketController');
		Route::name('lotteryEditionTickets.delete')->get('lotteryEditions/{lotteryEdition}/lotteryEditionTickets/delete/{lotteryEditionTicket}', ['uses' => 'LotteryEditionTicketController@destroy']);
		Route::name('lotteryEditionTickets.addUser')->get('lotteryEditions/{lotteryEdition}/addUser', ['uses' => 'LotteryEditionTicketController@addUser']);
		Route::name('lotteryEditionTickets.addUser.store')->post('lotteryEditions/{lotteryEdition}/addUser', ['uses' => 'LotteryEditionTicketController@addUserStore']);

		//lotteries
		Route::resource('lotteries', 'LotteryController');
		Route::name('lotteries.delete')->get('lotteries/delete/{lottery}', ['uses' => 'LotteryController@destroy']);
		Route::resource('lotteries/{lottery}/sharedTickets', 'SharedTicketController');
		Route::name('sharedTickets.delete')->get('lotteries/{lottery}/sharedTickets/delete/{sharedTicket}', ['uses' => 'SharedTicketController@destroy']);

		//settings
		Route::resource('settings', 'SettingsController');
		Route::name('settings.bySlug')->get('settings/slug/{slug}', 'SettingsController@GetSettingsBySlug');
		Route::name('settings.bySlug.edit')->get('settings/slug/{slug}/edit', 'SettingsController@EditSettingsBySlug');
		Route::name('settings.bySlug.update')->put('settings/slug/{slug}/update', 'SettingsController@UpdateSettingsBySlug');
		Route::name('settings.delete')->get('settings/delete/{setting}', ['uses' => 'SettingsController@destroy']);
    });

});

Route::post('getUsers', ['uses' => 'UserController@getUsers']);
Route::post('getUserTypes', ['uses' => 'UserTypeController@getUserTypes']);
Route::post('getLotteryTypes', ['uses' => 'LotteryTypeController@getLotteryTypes']);
Route::post('getLotteryEditions', ['uses' => 'LotteryEditionController@getLotteryEditions']);
Route::post('getLotteryEditionTickets', ['uses' => 'LotteryEditionTicketController@getLotteryEditionTickets']);
Route::post('getLotteries', ['uses' => 'LotteryController@getLotteries']);
Route::post('getSharedTickets', ['uses' => 'SharedTicketController@getSharedTickets']);

Route::post('getLotteryTicketsTo', ['uses' => 'LotteryEditionTicketController@getLotteryTicketsTo']);