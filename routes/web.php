<?php

/*
|--------------------------------------------------------------------------
| Application routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});

/*
    Partie Authentification
*/
Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

/*
    Partie Utilisateurs
*/
Route::get('profil/{user}', 'UserController@getProfile');
Route::post('changepassword', 'UserController@changePassword');
Route::resource('user', 'UserController');

/*
    Partie Séries
*/
Route::get('serie/{show_url}', 'ShowController@getShow')->name('show.fiche');
Route::get('serie/{show_url}/seasons', 'ShowController@getShowSeasons')->name('show.seasons');
Route::get('serie/{show_url}/details', 'ShowController@getShowDetails')->name('show.details');

/*
    Partie administration protégée par le middleware Admin (obligation d'être admin pour accéder aux routes)
*/
Route::group(['middleware' => 'admin'], function () {
    /* HOME */
    Route::get('admin', 'Admin\AdminController@index')->name('admin');

    /* SHOWS */
    Route::get('admin/shows/createManually', 'Admin\AdminShowController@createManually')->name('admin.shows.createManually');
    Route::post('admin/shows/storeManually', 'Admin\AdminShowController@storeManually')->name('admin.shows.storeManually');
    Route::post('admin/shows/updateManually', 'Admin\AdminShowController@updateManually')->name('admin.shows.updateManually');
    Route::get('admin/shows/redirectJSON', 'Admin\AdminShowController@redirectJSON')->name('admin.shows.redirectJSON');
    Route::get('admin/shows/{show}/editShow', 'Admin\AdminShowController@editShow')->name('admin.shows.editShow');
    Route::put('admin/shows/updateShow', 'Admin\AdminShowController@updateShow')->name('admin.shows.updateShow');
    Route::get('admin/shows/{show}/editSeasons', 'Admin\AdminShowController@editSeasons')->name('admin.shows.editSeasons');
    Route::resource('admin/shows', 'Admin\AdminShowController', [
        'names' => [
            'index' => 'admin.shows.index',
            'create' => 'admin.shows.create',
            'store' => 'admin.shows.store',
            'show' => 'admin.shows.show',
            'destroy' => 'admin.shows.destroy',
        ],
        'except' => [
            'edit', 'update'
        ]
    ]);

    /* ARTISTS */
    Route::resource('admin/artists', 'Admin\AdminArtistController', [
        'names' => [
            'index' => 'admin.artists',
            'create' => 'admin.artists.create',
            'store' => 'admin.artists.store',
            'show' => 'admin.artists.show',
            'update' => 'admin.artists.update',
            'destroy' => 'admin.artists.destroy',
            'edit' => 'admin.artists.edit'
        ]
    ]);

    /* SYSTEM */
    Route::get('admin/system', 'Admin\System\AdminSystemController@index')->name('admin.system');
    Route::get('admin/system/logs', 'Admin\System\AdminLogsController@index')->name('admin.logs');
    Route::get('admin/system/logs/view/{id}', 'Admin\System\AdminLogsController@view')->name('admin.logs.view');
});