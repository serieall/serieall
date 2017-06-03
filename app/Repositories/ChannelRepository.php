<?php


namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Facades\DB;

class ChannelRepository
{
    protected $channel;

    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return mixed
     */
    public function getChannels(){
        return DB::table('channels')
            ->orderBy('name', 'asc')
            ->get();
    }
}