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
    Route::get('admin/shows/create/manually', 'Admin\AdminShowController@createManually')->name('admin.shows.create.manually');
    Route::post('admin/shows/store/manually', 'Admin\AdminShowController@storeManually')->name('admin.shows.store.manually');
    Route::post('admin/shows/update/manually', 'Admin\AdminShowController@updateManually')->name('admin.shows.update.manually');
    Route::get('admin/shows/redirectJSON', 'Admin\AdminShowController@redirectJSON')->name('admin.shows.redirectJSON');
    Route::resource('admin/shows', 'Admin\AdminShowController', [
        'names' => [
            'index' => 'admin.shows.index',
            'create' => 'admin.shows.create',
            'store' => 'admin.shows.store',
            'show' => 'admin.shows.show',
            'edit' => 'admin.shows.edit',
            'update' => 'admin.shows.update',
            'destroy' => 'admin.shows.destroy',
        ],
    ]);

    /* ARTISTS */
    Route::delete('admin/artists/{artist}/{show}/unlinkShow', 'Admin\AdminArtistController@unlinkShow')->name('admin.artists.unlinkShow');
    Route::get('/admin/shows/{show}/artist/{artist}', 'Admin\AdminArtistController@edit')->name('admin.artists.edit');
    Route::post('/admin/shows/{show}/artist/{artist}', 'Admin\AdminArtistController@update')->name('admin.artists.update');
    Route::get('admin/artists/{show}', 'Admin\AdminArtistController@show')->name('admin.artists.show');
    Route::get('admin/artists/{show}/create', 'Admin\AdminArtistController@create')->name('admin.artists.create');
    Route::post('admin/artists/{show}/store', 'Admin\AdminArtistController@store')->name('admin.artists.store');
    Route::get('admin/artists/redirectJSON/{show}', 'Admin\AdminArtistController@redirectJSON')->name('admin.artists.redirectJSON');

    /* SEASONS */
    Route::get('admin/seasons/{show}', 'Admin\AdminSeasonController@show')->name('admin.seasons.show');
    Route::get('admin/seasons/{show}/create', 'Admin\AdminSeasonController@create')->name('admin.seasons.create');
    Route::get('admin/seasons/{show}/edit/{season}', 'Admin\AdminSeasonController@edit')->name('admin.seasons.edit');
    Route::post('admin/seasons/{season}/update', 'Admin\AdminSeasonController@update')->name('admin.seasons.update');

    /* EPISODES */


    /* SYSTEM */
    Route::get('admin/system', 'Admin\System\AdminSystemController@index')->name('admin.system');
    Route::get('admin/system/logs', 'Admin\System\AdminLogsController@index')->name('admin.logs');
    Route::get('admin/system/logs/view/{id}', 'Admin\System\AdminLogsController@view')->name('admin.logs.view');
});