<?php
    use Illuminate\Http\Request;
    use Dingo\Api\Routing\Router;
    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    $api = app(Router::class);

    $api->version('v1', [], function (Router $api){
       $api->get('shows/search', '\App\Http\Controllers\Api\V1\ShowSearchController@index');
        $api->get('nationalities', '\App\Http\Controllers\Api\V1\NationalitiesController@index');
    });