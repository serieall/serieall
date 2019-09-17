<?php

use GuzzleHttp\Client;

class GoApiImage {
    public $id = "";
    public $name  = "";
    public $type = "";
    public $size = "";
 }

class GoApiPublishImage {
    public $url = "";
    public $name  = "";
    public $crop_type = "";
    public $crop = "";
    public $force_crop = false;
}

function getImage($tvdbid, $url, $name, $type, $size) {
    $body = new GoApiImage();
    $body->id = $tvdbid;
    $body->url = $url;
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

function publishImage($url, $name, $crop_type, $crop, $force_crop) {
    $body = new GoApiPublishImage();
    $body->url = $url;
    $body->name = $name;
    $body->crop_type = $crop_type;
    $body->crop = $crop;
    $body->force_crop = $force_crop;

    $body = json_encode($body);
    # Creating client to API
    $client = new Client([
        'base_uri' => config('app.goapi_url'),
        'timeout'  => 2.0,
    ]);

    $response = $client->request('POST', '/images', ['body' => $body, 'headers' => [ 'Authorization' => "Bearer " . config('app.goapi_secret') ]]);
    if($response->getStatusCode() != 200) {
        return false;
    }

    return true;
}