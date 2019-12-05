<?php

declare(strict_types=1);

use App\Models\Channel;
use App\Models\Show;
use Illuminate\Support\Str;

function linkAndCreateChannelsToShow(Show $show, array $channels) {
    foreach ($channels as $channel) {
        $channel = trim($channel);
        $channelUrl = Str::slug($channel);

        $channelBdd = Channel::where('channel_url', $channelUrl)->first();
        if (is_null($channelBdd)) {
            $channelBdd = new Channel([
                'name' => $channel,
                'channel_url' => $channelUrl
            ]);
            $show->channels()->save($channelBdd);
            Log::debug('Channel : ' . $channelBdd->name . ' is created.');
        } else {
            $show->channels()->attach($channelBdd->id);
            Log::debug('Channel : ' . $channelBdd->name . ' is linked to ' . $show->name . '.');
        }
    }
}