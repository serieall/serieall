<?php

declare(strict_types=1);

use App\Models\Temp;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;

function apiTvdbGetConf(): array {
    return array(
        'api_key' => config('thetvdb.apikey'),
        'duration' => config('thetvdb.duration'),
        'url' => config('thetvdb.url'),
        'user_key' => config('thetvdb.userkey'),
        'username' => config('thetvdb.username'),
        'version' => config('thetvdb.version')
    );
}

/**
 * Authentication from the TVDB API
 *
 * @return string
 * @throws GuzzleException
 */
function apiTvdbGetToken(): string
{
    $theTvdbApi = apiTvdbGetConf();
    $client = new Client(['base_uri' => $theTvdbApi['url']]);

    $actualDate = Carbon::now();
    $tokenBdd = Temp::where('key', 'token')->first();
    $dateKeyToken = $tokenBdd->updated_at;

    # Compare actual date and token creation date
    $tokenAge = $actualDate->diffInHours($dateKeyToken);

    # If diff greater than duration of the lifetime of the token, we get a new one.
    if ($tokenAge > $theTvdbApi['duration']) {
        $tokenRequest = (string) $client->request('POST', '/login', [
            'header' => [
                'Accept' => 'application/vnd.thetvdb.v' . $theTvdbApi['version']],
            'json' => [
                'apikey' => $theTvdbApi['api_key'],
                'username' => $theTvdbApi['username'],
                'userkey' => $theTvdbApi['user_key']
            ]
        ])->getBody();

        Log::debug('TVDB API : Get token is successful. This the token : ' . $tokenRequest);

        $token = json_decode($tokenRequest)->token;

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
 * @throws GuzzleException
 */
function apiTvdbGetShow(string $language, int $tvdbId) : string
{
    $theTvdbApi = apiTvdbGetConf();
    $client = new Client(['base_uri' => $theTvdbApi['url']]);

    $token = apiTvdbGetToken();

    try {
        $showRequest = (string) $client->request('GET', '/series/' . $tvdbId, [
            'headers' => [
                'Accept' => 'application/json,application/vnd.thetvdb.v' . $theTvdbApi['version'],
                'Authorization' => 'Bearer ' . $token,
                'Accept-Language' => $language
            ]
        ])->getBody();

        Log::debug('TVDB API : Get show is successful. This the object : ' . $showRequest);

        return $showRequest;
    } catch (ClientException $e) {
        Log::info('TVDB API : The show ' . $tvdbId . ' does not exists');
    }
}
