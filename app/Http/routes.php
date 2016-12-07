<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
    Partie Authentification
*/
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('user/activation/{token}', 'Auth\LoginController@activateUser')->name('user.activate');

Route::get('/home', 'HomeController@index');

/*
    Partie Utilisateurs
*/
Route::resource('user', 'UserController');
Route::get('profil/{user}', 'UserController@getProfile');
Route::post('changepassword', 'UserController@changePassword');


/*
    Partie administration protégée par le middleware Admin (obligation d'être admin pour accéder aux routes)
*/
Route::group(['middleware' => 'admin'], function () {
    Route::get('admin', 'Admin\AdminController@index')->name('adminIndex');

    Route::get('adminShow/createManually', 'Admin\AdminShowController@createManually')->name('adminShow.createManually');
    Route::post('adminShow/storeManually', 'Admin\AdminShowController@storeManually')->name('adminShow.storeManually');
    Route::get('adminShow/redirectJSON', 'Admin\AdminShowController@redirectJSON')->name('adminShow.redirectJSON');
    Route::resource('adminShow', 'Admin\AdminShowController');
});