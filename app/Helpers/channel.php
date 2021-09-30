<?php

declare(strict_types=1);

use App\Models\Channel;
use App\Models\Show;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

function linkAndCreateChannelsToShow(Show $show, array $channels)
{
    foreach ($channels as $channel) {
        $channel = trim($channel);
        $channelUrl = Str::slug($channel);

        $channelBdd = Channel::where('channel_url', $channelUrl)->first();
        if (is_null($channelBdd)) {
            $channelBdd = new Channel([
                'name' => $channel,
                'channel_url' => $channelUrl,
            ]);
            $show->channels()->save($channelBdd);
            Log::debug('Channel : '.$channelBdd->name.' is created.');
        } else {
            $channelLink = $channelBdd->shows()->where('shows.tmdb_id', $show->tmdb_id)->first();
            if (empty($channelLink)) {
                $show->channels()->attach($channelBdd->id);
                Log::debug('Channel : '.$channelBdd->name.' is linked to '.$show->name.'.');
            } else {
                Log::debug('Channel : '.$channelBdd->name.' is already linked to '.$show->name.'.');
            }
        }
    }
}
