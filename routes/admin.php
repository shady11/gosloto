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



        // lotteries
        Route::name('lottery.index')->get('lottery/all', ['uses' => 'NavController@lottery']);

        // draw lotteries
        Route::resource('drawLottery', 'DrawLotteryController');
        Route::name('drawLottery.delete')->get('drawLottery/delete/{drawLottery}', ['uses' => 'DrawLotteryController@destroy']);
        Route::name('drawLottery.reportAll')->get('drawLottery/report/all', ['uses' => 'DrawLotteryController@reportAll']);
        Route::resource('drawLottery/{drawLottery}/draw', 'DrawController', ['as' => 'drawLottery']);
        Route::name('drawLottery.draw.delete')->get('drawLottery/{drawLottery}/draw/{draw}/delete', ['uses' => 'DrawController@destroy']);
        Route::name('drawLottery.draw.report')->get('drawLottery/{drawLottery}/draw/{draw}/report', ['uses' => 'DrawController@report']);
        Route::resource('drawLottery/{drawLottery}/draw/{draw}/ticket', 'DrawTicketController', ['as' => 'drawLottery.draw']);
        Route::name('drawLottery.draw.ticket.delete')->get('drawLottery/{drawLottery}/draw/{draw}/ticket/{ticket}/delete', ['uses' => 'DrawTicketController@destroy']);
        Route::name('drawLottery.draw.ticket.update')->post('drawLottery/{drawLottery}/draw/{draw}/ticket/{ticket}/update', ['uses' => 'DrawTicketController@update']);
        Route::name('drawLottery.draw.ticketsAdd')->get('drawLottery/{drawLottery}/draw/{draw}/ticketsAdd', ['uses' => 'DrawTicketController@ticketsAdd']);
        Route::name('drawLottery.draw.ticketsAddStore')->post('drawLottery/{drawLottery}/draw/{draw}/ticketsAddStore', ['uses' => 'DrawTicketController@ticketsAddStore']);
        Route::name('drawLottery.draw.ticketsShare')->get('drawLottery/{drawLottery}/draw/{draw}/ticketsShare', ['uses' => 'DrawTicketController@ticketsShare']);
        Route::name('drawLottery.draw.ticketsShareStore')->post('drawLottery/{drawLottery}/draw/{draw}/ticketsShareStore', ['uses' => 'DrawTicketController@ticketsShareStore']);
        Route::name('drawLottery.draw.ticketsReturn')->get('drawLottery/{drawLottery}/draw/{draw}/ticketsReturn', ['uses' => 'DrawTicketController@ticketsReturn']);
        Route::name('drawLottery.draw.ticketsReturnStore')->post('drawLottery/{drawLottery}/draw/{draw}/ticketsReturnStore', ['uses' => 'DrawTicketController@ticketsReturnStore']);
        Route::name('drawLottery.draw.ticketsReturnScan')->get('drawLottery/{drawLottery}/draw/{draw}/ticketsReturnScan', ['uses' => 'DrawTicketController@ticketsReturnScan']);
        Route::name('drawLottery.draw.ticketsReturnScanStore')->post('drawLottery/{drawLottery}/draw/{draw}/ticketsReturnScanStore', ['uses' => 'DrawTicketController@ticketsReturnScanStore']);
        Route::name('drawLottery.draw.ticketsSold')->get('drawLottery/{drawLottery}/draw/{draw}/ticketsSold', ['uses' => 'DrawTicketController@ticketsSold']);

        // instant lotteries
        Route::resource('instantLottery', 'InstantLotteryController');
        Route::name('instantLottery.delete')->get('instantLottery/delete/{instantLottery}', ['uses' => 'InstantLotteryController@destroy']);
        Route::name('instantLottery.reportAll')->get('instantLottery/report/all', ['uses' => 'InstantLotteryController@reportAll']);
        Route::resource('instantLottery/{instantLottery}/sharedTicket', 'InstantLotterySharedTicketController', ['as' => 'instantLottery']);
        Route::name('instantLottery.sharedTicket.delete')->get('instantLottery/{instantLottery}/sharedTicket/delete/{sharedTicket}', ['uses' => 'InstantLotterySharedTicketController@destroy']);
        Route::name('instantLottery.sharedTicket.ticketsSold')
            ->get('instantLottery/{instantLottery}/sharedTicket/{sharedTicket}/ticketsSold', ['uses' => 'InstantLotterySharedTicketController@ticketsSold']);
        Route::name('instantLottery.sharedTicket.ticketsSoldStore')
            ->post('instantLottery/{instantLottery}/sharedTicket/{sharedTicket}/ticketsSoldStore', ['uses' => 'InstantLotterySharedTicketController@ticketsSoldStore']);
        Route::name('instantLottery.sharedTicket.ticketsReturned')
            ->get('instantLottery/{instantLottery}/sharedTicket/{sharedTicket}/ticketsReturned', ['uses' => 'InstantLotterySharedTicketController@ticketsReturned']);
        Route::name('instantLottery.sharedTicket.ticketsReturnedStore')
            ->post('instantLottery/{instantLottery}/sharedTicket/{sharedTicket}/ticketsReturnedStore', ['uses' => 'InstantLotterySharedTicketController@ticketsReturnedStore']);
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

//v2.0 routes

//draw lotteries
Route::get('getDrawLotteries', ['uses' => 'DataTableController@getDrawLotteries']);
Route::get('getLotteryDraws', ['uses' => 'DataTableController@getLotteryDraws']);
Route::get('getDrawCreatedTickets', ['uses' => 'DataTableController@getDrawCreatedTickets']);
Route::get('getDrawReturnedTickets', ['uses' => 'DataTableController@getDrawReturnedTickets']);

//instant lotteries
Route::get('getInstantLotteries', ['uses' => 'DataTableController@getInstantLotteries']);
Route::get('getInstantLotterySharedTickets', ['uses' => 'DataTableController@getInstantLotterySharedTickets']);

// reports
Route::get('reportGetDrawLotteries', ['uses' => 'ReportController@reportGetDrawLotteries']);
Route::get('reportGetInstantLotteries', ['uses' => 'ReportController@reportGetInstantLotteries']);
Route::get('reportGetDraws', ['uses' => 'ReportController@reportGetDraws']);