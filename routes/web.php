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
})->name('home');

Route::get('/cgu', function () {
    return view('pages.cgu');
})->name('cgu');

/*
    Partie Authentification
*/
Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

/*
    Partie Utilisateurs
*/
Route::get('profil/{user}', 'UserController@getProfile')->name('user.profile');
Route::get('profil/{user}/parametres', 'UserController@getParameters')->name('user.profile.parameters')->middleware('amithisuser');
Route::post('changepassword', 'UserController@changePassword')->name('user.changepassword')->middleware('auth');
Route::post('changeinfos', 'UserController@changeInfos')->name('user.changeinfos')->middleware('auth');

/*
    Partie Séries
*/
Route::get('serie/{show_url}', 'ShowController@getShowFiche')->name('show.fiche');
Route::get('details/{show_url}', 'ShowController@getShowDetails')->name('show.details');

/*
    Partie Saisons
 */
Route::get('saison/{show_url}/{season}', 'SeasonController@getSeasonFiche')->name('season.fiche');

/*
    Partie Episodes
 */
Route::get('episode/{show_url}/s{season}e{episode}/{id?}', 'EpisodeController@getEpisodeFiche')->name('episode.fiche');
Route::post('episode/rate', 'EpisodeController@rateEpisode')->name('episode.rate')->middleware('auth');

/*
    Partie Commentaire
*/
Route::get('avis/{show_url}/{season?}/{episode?}/{episode_id?}', 'CommentController@fiche')->name('comment.fiche');
Route::post('comment', 'CommentController@store')->name('comment.store')->middleware('auth');

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
    Route::get('admin/shows/{show}/artists', 'Admin\AdminArtistController@show')->name('admin.artists.show');
    Route::get('admin/shows/{show}/artists/create', 'Admin\AdminArtistController@create')->name('admin.artists.create');
    Route::post('admin/artists', 'Admin\AdminArtistController@store')->name('admin.artists.store');
    Route::get('admin/shows/{show}/artists/{artist}', 'Admin\AdminArtistController@edit')->name('admin.artists.edit');
    Route::put('admin/artists', 'Admin\AdminArtistController@update')->name('admin.artists.update');
    Route::get('admin/artists/{show}/redirect', 'Admin\AdminArtistController@redirect')->name('admin.artists.redirect');
    Route::delete('admin/shows/{show}/artists/{artist}/unlinkShow', 'Admin\AdminArtistController@unlinkShow')->name('admin.artists.unlinkShow');

    /* SEASONS */
    Route::get('admin/shows/{show}/seasons', 'Admin\AdminSeasonController@show')->name('admin.seasons.show');
    Route::get('admin/shows/{show}/seasons/create', 'Admin\AdminSeasonController@create')->name('admin.seasons.create');
    Route::post('admin/seasons', 'Admin\AdminSeasonController@store')->name('admin.seasons.store');
    Route::get('admin/seasons/{season}/edit', 'Admin\AdminSeasonController@edit')->name('admin.seasons.edit');
    Route::put('admin/seasons/{season}', 'Admin\AdminSeasonController@update')->name('admin.seasons.update');
    Route::get('admin/seasons/{show}/redirect', 'Admin\AdminSeasonController@redirect')->name('admin.seasons.redirect');
    Route::delete('admin/seasons/{season}', 'Admin\AdminSeasonController@destroy')->name('admin.seasons.destroy');

    /* EPISODES */
    Route::get('admin/seasons/{season}/episodes/create', 'Admin\AdminEpisodeController@create')->name('admin.episodes.create');
    Route::post('admin/episodes', 'Admin\AdminEpisodeController@store')->name('admin.episodes.store');
    Route::get('admin/episodes/{episode}', 'Admin\AdminEpisodeController@edit')->name('admin.episodes.edit');
    Route::put('admin/episodes/update', 'Admin\AdminEpisodeController@update')->name('admin.episodes.update');
    Route::get('admin/episodes/{season}/redirect', 'Admin\AdminEpisodeController@redirect')->name('admin.episodes.redirect');
    Route::delete('admin/episodes/{episode}', 'Admin\AdminEpisodeController@destroy')->name('admin.episodes.destroy');

    /* USERS */
    Route::get('admin/users', 'Admin\AdminUserController@index')->name('admin.users.index');
    Route::get('admin/users/create', 'Admin\AdminUserController@create')->name('admin.users.create');
    Route::post('admin/users', 'Admin\AdminUserController@store')->name('admin.users.store');
    Route::get('admin/users/{user}', 'Admin\AdminUserController@edit')->name('admin.users.edit');
    Route::put('admin/users/update', 'Admin\AdminUserController@update')->name('admin.users.update');
    Route::post('admin/users/ban/{user}', 'Admin\AdminUserController@ban')->name('admin.users.ban');
    Route::post('admin/users/reinit/{user}', 'Admin\AdminUserController@reinit')->name('admin.users.reinit');
    Route::delete('admin/users/{user}', 'Admin\AdminUserController@destroy')->name('admin.users.destroy');

    /* SYSTEM */
    Route::get('admin/system', 'Admin\System\AdminSystemController@index')->name('admin.system');
    Route::get('admin/system/logs', 'Admin\System\AdminLogsController@index')->name('admin.logs');
    Route::get('admin/system/logs/view/{id}', 'Admin\System\AdminLogsController@view')->name('admin.logs.view');
});