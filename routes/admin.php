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
//        Route::name('users.sellers')->get('users/sellers}', 'UserController@GetSellers');

		// user types routes
		Route::resource('userTypes', 'UserTypeController');
		Route::name('userTypes.delete')->get('userTypes/delete/{userType}', ['uses' => 'UserTypeController@destroy']);

		// lottery types routes
		Route::resource('lotteryTypes', 'LotteryTypeController');
		Route::name('lotteryTypes.delete')->get('lotteryTypes/delete/{lotteryType}', ['uses' => 'LotteryTypeController@destroy']);
        Route::resource('lotteryTypes/{lotteryType}/lotteryEdition', 'LotteryTypeEditionController', ['as' => 'lottery']);
        Route::name('lottery.lotteryEdition.delete')->get('lotteryTypes/{lotteryType}/edition/{lotteryEdition}/delete', ['uses' => 'LotteryTypeEditionController@destroy']);

        // lottery editions routes
		Route::resource('lotteryEditions', 'LotteryEditionController');
		Route::name('lotteryEditions.delete')->get('lotteryEditions/delete/{lotteryEdition}', ['uses' => 'LotteryEditionController@destroy']);

		// lottery edition tickets routes
		Route::resource('lotteryEditions/{lotteryEdition}/lotteryEditionTickets', 'LotteryEditionTicketController');
		Route::name('lotteryEditionTickets.delete')->get('lotteryEditions/{lotteryEdition}/lotteryEditionTickets/delete/{lotteryEditionTicket}', ['uses' => 'LotteryEditionTicketController@destroy']);
		Route::name('lotteryEditionTickets.addUser')->get('lotteryEditions/{lotteryEdition}/addUser', ['uses' => 'LotteryEditionTicketController@addUser']);
		Route::name('lotteryEditionTickets.addUser.store')->post('lotteryEditions/{lotteryEdition}/addUser', ['uses' => 'LotteryEditionTicketController@addUserStore']);
		Route::name('lotteryEditionTickets.updateTicket')->post('lotteryEditions/{lotteryEdition}/updateTicket/{id}', ['uses' => 'LotteryEditionTicketController@update']);
        Route::name('lotteryEditionTickets.addTicketsBack')->get('lotteryEditions/{lotteryEdition}/addTicketsBack', ['uses' => 'LotteryEditionTicketController@addTicketsBack']);
        Route::name('lotteryEditionTickets.addTicketsBack.store')->post('lotteryEditions/{lotteryEdition}/addTicketsBack', ['uses' => 'LotteryEditionTicketController@addTicketsBackStore']);
        Route::name('lotteryEditionTickets.ticketReturn.delete')->get('lotteryEditions/{lotteryEdition}/ticketReturn/{lotteryEditionTicket}/delete', ['uses' => 'LotteryEditionTicketController@deleteTicketReturn']);
        Route::name('lotteryEditionTickets.addTickets')->get('lotteryEditions/{lotteryEdition}/addTickets', ['uses' => 'LotteryEditionTicketController@addTickets']);
        Route::name('lotteryEditionTickets.addTickets.store')->post('lotteryEditions/{lotteryEdition}/addTickets', ['uses' => 'LotteryEditionTicketController@addTicketsStore']);

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

        // reports routes
        Route::resource('reports', 'ReportController');
        Route::get('reportspdf', ['uses' => 'ReportController@GetPdf']);
    });

});

Route::post('getUsers', ['uses' => 'UserController@getUsers']);
Route::post('getUserTypes', ['uses' => 'UserTypeController@getUserTypes']);
Route::post('getLotteryTypes', ['uses' => 'LotteryTypeController@getLotteryTypes']);
Route::get('getLotteryTypeEditions', ['uses' => 'LotteryTypeController@getLotteryTypeEditions']);
Route::post('getLotteryEditions', ['uses' => 'LotteryEditionController@getLotteryEditions']);
Route::get('getLotteryEditionTickets', ['uses' => 'LotteryEditionTicketController@getLotteryEditionTickets']);
Route::get('getLotteryEditionTicketsBack', ['uses' => 'LotteryEditionTicketController@getLotteryEditionTicketsBack']);
Route::post('getLotteries', ['uses' => 'LotteryController@getLotteries']);
Route::post('getSharedTickets', ['uses' => 'SharedTicketController@getSharedTickets']);

Route::post('getLotteryTicketsTo', ['uses' => 'LotteryEditionTicketController@getLotteryTicketsTo']);
Route::post('getLotteryEditionsById', ['uses' => 'ReportController@getLotteryEditionsById']);

Route::post('reportGetLotteryTypes', ['uses' => 'ReportController@reportGetLotteryTypes']);
Route::post('reportGetLotteryEditions', ['uses' => 'ReportController@reportGetLotteryEditions']);

// if(auth()->user()->isStock()){} elseif(auth()->user()->isSupervisor()) {} else {}