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
Route::get('serie/{show_url}', 'ShowController@getShow')->name('fiche');

/*
    Partie administration protégée par le middleware Admin (obligation d'être admin pour accéder aux routes)
*/
Route::group(['middleware' => 'admin'], function () {
    /* HOME */
    Route::get('admin', 'Admin\AdminController@index')->name('adminIndex');

    /* SHOWS */
    Route::get('admin/show/createManually', 'Admin\AdminShowController@createManually')->name('adminShow.createManually');
    Route::post('admin/show/storeManually', 'Admin\AdminShowController@storeManually')->name('adminShow.storeManually');
    Route::post('admin/show/updateManually', 'Admin\AdminShowController@updateManually')->name('adminShow.updateManually');
    Route::get('admin/show/redirectJSON', 'Admin\AdminShowController@redirectJSON')->name('adminShow.redirectJSON');
    Route::resource('adminShow', 'Admin\AdminShowController');

    /* ARTISTS */
    Route::resource('adminArtist', 'Admin\AdminArtistController');

    /* SYSTEM */
    Route::get('admin/log/{id}', 'Admin\AdminController@viewLog')->name('adminLog');
});