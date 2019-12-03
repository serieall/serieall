<?php

declare(strict_types=1);

use Carbon\Carbon;

use App\Models\Temp;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;

/**
 * Authentication from the TVDB API
 *
 * @return string
 */
function apiTvdbGetToken(): string
{
    $theTvdbApi = array(
        'api_key' => config('thetvdb.apikey'),
        'duration' => config('thetvdb.duration'),
        'url' => config('thetvdb.url'),
        'user_key' => config('thetvdb.userkey'),
        'username' => config('thetvdb.username'),
        'version' => config('thetvdb.version')
    );
    $client = new Client(['base_uri' => $theTvdbApi['url']]);
    $actualDate = Carbon::now();

    $tokenBdd = Temp::where('key', 'token')->first();
    $dateKeyToken = $tokenBdd->updated_at;

    # Compare actual date and token creation date
    $tokenAge = $actualDate->diffInHours($dateKeyToken);

    # If diff greather than duration of the lifetime of the token, we get a new one.
    if ($tokenAge > $theTvdbApi['duration']) {
        $tokenRequest = $client->request('POST', '/login', [
            'header' => [
                'Accept' => 'application/vnd.thetvdb.v' . $theTvdbApi['version']
            ],
            'json' => [
                'apikey' => $theTvdbApi['api_key'],
                'username' => $theTvdbApi['username'],
                'userkey' => $theTvdbApi['user_key']
            ]
        ])->getBody();

        Log::debug('TVDB API : Get token is successful. This the token : ' . $tokenRequest);

        $token = json_decode($tokenRequest);
        Log::info($token);
        $tokenBdd->value = $token;
        $tokenBdd->save();
    }

    return $tokenBdd->value;
}

/**
 * Get Show from TVDB
 *
 * @param string $language
 * @param integer $tvdbId
 * @return void
 */
function apiTvdbGetShow(string $language, int $tvdbId)
{
    $theTvdbApi = array(
        'api_key' => config('thetvdb.apikey'),
        'duration' => config('thetvdb.duration'),
        'url' => config('thetvdb.url'),
        'user_key' => config('thetvdb.userkey'),
        'username' => config('thetvdb.username'),
        'version' => config('thetvdb.version')
    );
    $client = new Client(['base_uri' => $theTvdbApi['url']]);

    $token = apiTvdbGetToken();

    try {
        $showRequest = $client->request('GET', '/series/' . $tvdbId, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $theTvdbApi['version'],
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => $language
            ]
        ])->getBody();

        Log::debug('TVDB API : Get show is successful. This the object : ' . $showRequest);

        return $showRequest;
    } catch (ClientException $e) {
        Log::error('The show ' . $tvdbId . ' does not exists');
    }
}
