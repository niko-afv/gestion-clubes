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
        Route::get('/list', 'ClubesListController@index')->name('clubes_list');

        Route::get('/create', 'ClubesFormController@index')->name('clubes_create');
    });

    Route::prefix('perfil')->namespace('Profile')->group(function (){
        Route::get('/', 'VerPerfilController@index')->name('profile');
    });
});

