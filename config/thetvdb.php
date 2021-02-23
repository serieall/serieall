<?php

declare(strict_types=1);

return [
    // Params for authentication
    'apikey' => env('TVDB_APIKEY', ''),
    'username' => env('TVDB_USERNAME', ''),
    'userkey' => env('TVDB_USERKEY', ''),

    // Defaults
    'url' => 'https://api.thetvdb.com/',
    'imageUrl' => 'https://artworks.thetvdb.com/banners/',
    'version' => '3.0.0',
    'duration' => '12',
];
