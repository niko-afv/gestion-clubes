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


Route::post('register/activate', 'Auth\RegisterController@activate')->name('activate_club');
Route::get('register/confirm_activation/{token}', 'Auth\RegisterController@confirmActivation')->name('confirm_activation');

Route::middleware('auth')->group(function (){
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('clubes')->namespace('Clubs')->group(function (){
        Route::get('/list', 'ClubsListController@index')->name('clubes_list');
        Route::get('/import', 'ClubsListController@import')->name('clubes_import');
        Route::get('/detail/{club}', 'ClubsListController@detail')->name('club_detail');
        Route::get('/create', 'ClubsFormController@index')->name('clubes_create');
    });


    Route::prefix('unidades')->namespace('Clubs')->group(function (){
        Route::get('/list', 'ClubsListController@unidades')->name('unidades_list');
    });


    Route::prefix('eventos')->namespace('Events')->group(function (){

        Route::get('/list', 'EventsController@index')->name('events_list');
        Route::get('/detail/{event}', 'EventsController@detail')->name('event_detail');

        Route::get('/create', 'EventsController@create')->name('events_create');
        Route::post('/save', 'EventsController@save')->name('events_save');
        Route::post('/{event}/toggle', 'EventsController@toggle')->name('event_toggle');

        Route::get('/update/{event}', 'EventsController@showUpdate')->name('event_edit');
        Route::post('/update/{event}', 'EventsController@update')->name('event_update');

        Route::get('/{event_id}/inscribir/', 'EventsController@showInscribe')->name('show_inscribe');
        Route::post('/{event}/inscribir/', 'EventsController@inscribe')->name('inscribe');
        Route::post('/{event}/desincribir/', 'EventsController@unsubscribe')->name('unsubscribe');

        Route::post('/{event}/remove_zone', 'EventsController@removeZone')->name('remove_zone');
        Route::post('/{event}/remove_activity', 'EventsController@removeActivity')->name('remove_zone');

        Route::post('/{event}/add_activity', 'EventsController@addActivity')->name('add_activity');
    });

    Route::prefix('perfil')->namespace('Profile')->group(function (){
        Route::get('/', 'ProfileController@index')->name('profile');
    });

    Route::prefix('mi_club')->namespace('Clubs')->group(function (){
        Route::get('/', 'MyClubController@index')->name('my_club');

        Route::get('/miembros/importar', 'MyClubController@showMemberImport')->name('import_member');
        Route::post('/miembros/upload', 'MyClubController@uploadMembers')->name('upload_members');
        Route::post('/miembros/importar', 'MyClubController@importMembers')->name('import_save_members');

        Route::get('/miembros/nuevo', 'MyClubController@showAddMember')->name('add_member');
        Route::get('/miembros/{member}', 'MyClubController@showUpdateMember')->name('edit_member');
        Route::post('/miembros/guardar', 'MyClubController@saveMember')->name('save_member');
        Route::post('/miembros/guardar/{member}', 'MyClubController@updateMember')->name('update_member');
        Route::post('/unidad/{member}/remover_cargo', 'MyClubController@removePosition')->name('remove_position');

        Route::post('/miembros/eliminar', 'MyClubController@deleteMember')->name('delete_member');

        Route::get('/unidad/nueva', 'MyClubController@showAddUnit')->name('add_unit');
        Route::get('/unidad/{unit}', 'MyClubController@showUpdateUnit')->name('edit_unit');
        Route::post('/unidad/guardar/', 'MyClubController@saveUnit')->name('save_unit');
        Route::post('/unidad/guardar/{oUnit}', 'MyClubController@updateUnit')->name('update_unit');
        Route::post('/unidad/{oUnit}/remover_miembro', 'MyClubController@removeMember')->name('remove_member');
    });
});

