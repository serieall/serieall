<?php

use GuzzleHttp\Client;

class GoApiImage {
    public $id = "";
    public $name  = "";
    public $type = "";
    public $size = "";
 }

function getImage($tvdbid, $name, $type, $size) {
    $body = new GoApiImage();
    $body->id = $tvdbid;
    $body->name = $name;
    $body->type = $type;
    $body->size = $size;

    $body = json_encode($body);
    # Creating client to API
    $client = new Client([
        'base_uri' => config('app.goapi_url'),
        'timeout'  => 2.0,
    ]);

    $response = $client->request('GET', '/images', ['body' => $body, 'headers' => [ 'Authorization' => "Bearer " . config('app.goapi_secret') ]]);
    if($response->getStatusCode() != 200) {
        return "/var/www/images/original/default.jpg";
    }


    return json_decode($response->getBody())->url;
}