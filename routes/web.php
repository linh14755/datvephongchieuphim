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

//back-end

Route::get('/register', 'AdminController@registerAdmin');
Route::post('/register', 'AdminController@postregisterAdmin');


Route::get('/admin', 'AdminController@loginAdmin');
Route::post('/admin', 'AdminController@postloginAdmin');

Route::get('/admin/home', function () {
    return view('admin.home');
});

//Admin
Route::prefix('admin')->group(function () {
    //logout
    Route::get('/', [
        'as' => 'logout.logout',
        'uses' => 'AdminController@logout'
    ]);

    //Users
    Route::prefix('users')->group(function () {
        Route::get('/', [
            'as' => 'users.index',
            'uses' => 'AdminUserController@index',
        ]);

        Route::get('/create', [
            'as' => 'users.create',
            'uses' => 'AdminUserController@create',
        ]);
    });

    //Type of movie
    Route::prefix('type-of-movie')->group(function () {

        Route::get('/', [
            'as' => 'typeofmovie.index',
            'uses' => 'AdminTypeOfMovieController@index',
        ]);

        Route::get('/create', [
            'as' => 'typeofmovie.create',
            'uses' => 'AdminTypeOfMovieController@create',
        ]);

        Route::post('/store', [
            'as' => 'typeofmovie.store',
            'uses' => 'AdminTypeOfMovieController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'typeofmovie.edit',
            'uses' => 'AdminTypeOfMovieController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'typeofmovie.update',
            'uses' => 'AdminTypeOfMovieController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'typeofmovie.delete',
            'uses' => 'AdminTypeOfMovieController@delete',
        ]);

    });

    //Movie format
    Route::prefix('movie-format')->group(function () {

        Route::get('/', [
            'as' => 'movieformat.index',
            'uses' => 'AdminMovieFormatController@index',
        ]);

        Route::get('/create', [
            'as' => 'movieformat.create',
            'uses' => 'AdminMovieFormatController@create',
        ]);

        Route::post('/store', [
            'as' => 'movieformat.store',
            'uses' => 'AdminMovieFormatController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'movieformat.edit',
            'uses' => 'AdminMovieFormatController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'movieformat.update',
            'uses' => 'AdminMovieFormatController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'movieformat.delete',
            'uses' => 'AdminMovieFormatController@delete',
        ]);
    });

    //Movies
    Route::prefix('movie')->group(function () {

        Route::get('/', [
            'as' => 'movie.index',
            'uses' => 'AdminMovieController@index',
        ]);

        Route::get('/create', [
            'as' => 'movie.create',
            'uses' => 'AdminMovieController@create',
        ]);

        Route::post('/store', [
            'as' => 'movie.store',
            'uses' => 'AdminMovieController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'movie.edit',
            'uses' => 'AdminMovieController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'movie.update',
            'uses' => 'AdminMovieController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'movie.delete',
            'uses' => 'AdminMovieController@delete',
        ]);

        Route::get('/search', [
            'as' => 'movie.search',
            'uses' => 'AdminMovieController@search',
        ]);

    });

    //Customers
    Route::prefix('customer')->group(function () {

        Route::get('/', [
            'as' => 'customer.index',
            'uses' => 'AdminCustomerController@index',
        ]);

        Route::get('/create', [
            'as' => 'customer.create',
            'uses' => 'AdminCustomerController@create',
        ]);

        Route::post('/store', [
            'as' => 'customer.store',
            'uses' => 'AdminCustomerController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'customer.edit',
            'uses' => 'AdminCustomerController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'customer.update',
            'uses' => 'AdminCustomerController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'customer.delete',
            'uses' => 'AdminCustomerController@delete',
        ]);

    });

    //Ticket Type
    Route::prefix('ticket-type')->group(function () {

        Route::get('/', [
            'as' => 'tickettype.index',
            'uses' => 'AdminTicketTypeController@index',
        ]);

        Route::get('/create', [
            'as' => 'tickettype.create',
            'uses' => 'AdminTicketTypeController@create',
        ]);

        Route::post('/store', [
            'as' => 'tickettype.store',
            'uses' => 'AdminTicketTypeController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'tickettype.edit',
            'uses' => 'AdminTicketTypeController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'tickettype.update',
            'uses' => 'AdminTicketTypeController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'tickettype.delete',
            'uses' => 'AdminTicketTypeController@delete',
        ]);


    });

    //Cinema
    Route::prefix('cinema')->group(function () {

        Route::get('/', [
            'as' => 'cinema.index',
            'uses' => 'AdminCinemaController@index',
        ]);

        Route::get('/create', [
            'as' => 'cinema.create',
            'uses' => 'AdminCinemaController@create',
        ]);

        Route::post('/store', [
            'as' => 'cinema.store',
            'uses' => 'AdminCinemaController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'cinema.edit',
            'uses' => 'AdminCinemaController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'cinema.update',
            'uses' => 'AdminCinemaController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'cinema.delete',
            'uses' => 'AdminCinemaController@delete',
        ]);

    });

    //Screening title
    Route::prefix('screening-titles')->group(function () {

        Route::get('/', [
            'as' => 'screeningtitle.index',
            'uses' => 'AdminScreeningTitleController@index',
        ]);

        Route::get('/create', [
            'as' => 'screeningtitle.create',
            'uses' => 'AdminScreeningTitleController@create',
        ]);

        Route::post('/store', [
            'as' => 'screeningtitle.store',
            'uses' => 'AdminScreeningTitleController@store',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'screeningtitle.edit',
            'uses' => 'AdminScreeningTitleController@edit',
        ]);

        Route::post('/update/{id}', [
            'as' => 'screeningtitle.update',
            'uses' => 'AdminScreeningTitleController@update',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'screeningtitle.delete',
            'uses' => 'AdminScreeningTitleController@delete',
        ]);


    });

    //Book Tickets
    Route::prefix('book-tickets')->group(function () {

        Route::get('/', [
            'as' => 'bookticket.index',
            'uses' => 'AdminBookTicketsController@index',
        ]);

        Route::get('/create/{id}', [
            'as' => 'bookticket.create',
            'uses' => 'AdminBookTicketsController@create',
        ]);

        Route::post('/store', [
            'as' => 'bookticket.store',
            'uses' => 'AdminBookTicketsController@store',
        ]);

    });

    //List Tickets
    Route::prefix('list-tickets')->group(function () {

        Route::get('/', [
            'as' => 'listticket.index',
            'uses' => 'AdminListTicketsController@index',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'listticket.edit',
            'uses' => 'AdminListTicketsController@edit',
        ]);

        Route::get('/print/{id}', [
            'as' => 'listticket.print',
            'uses' => 'AdminListTicketsController@print',
        ]);

        Route::post('/printpdf/{id}', [
            'as' => 'listticket.printpdf',
            'uses' => 'AdminListTicketsController@printpdf',
        ]);

        Route::post('/check-out-ticket/', [
            'as' => 'listticket.checkout',
            'uses' => 'AdminListTicketsController@checkout',
        ]);
    });
});
