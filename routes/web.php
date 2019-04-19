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

Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('clubes')->namespace('Clubs')->group(function (){
        Route::get('/list', 'ClubsListController@index')->name('clubes_list');
        Route::get('/import', 'ClubsListController@import')->name('clubes_import');
        Route::get('/detail/{club}', 'ClubsListController@detail')->name('club_detail');

        Route::get('/create', 'ClubsFormController@index')->name('clubes_create');
    });


    Route::prefix('eventos')->namespace('Events')->group(function (){

        Route::get('/list', 'EventsController@index')->name('events_list');
        Route::get('/detail/{event}', 'EventsController@detail')->name('event_detail');

        Route::get('/create', 'EventsController@create')->name('events_create');
        Route::post('/save', 'EventsController@save')->name('events_save');
        Route::post('/{event}/toggle', 'EventsController@toggle')->name('event_toggle');
    });

    Route::prefix('perfil')->namespace('Profile')->group(function (){
        Route::get('/', 'ProfileController@index')->name('profile');
    });
});

