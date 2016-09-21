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
Route::auth();
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');

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
    Route::get('/admin', 'AdminController@index')->name('index');
    Route::get('/admin/series', 'AdminShowController@indexShows')->name('indexShows');
    Route::get('/admin/series/add', 'AdminShowController@addShow')->name('addShow');
    Route::post('/admin/series/create', 'AdminShowController@createShow')->name('createShow');
})->name('admin');