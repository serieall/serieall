<?php
declare(strict_types=1);


namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Facades\DB;

/**
 * Class ChannelRepository
 * @package App\Repositories
 */
class ChannelRepository
{
    protected $channel;

    /**
     * ChannelRepository constructor.
     *
     * @param Channel $channel
     */
    public function __construct(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * On récupère toutes les chaines
     *
     * @return mixed
     */
    public function getChannels(){
        return DB::table('channels')
            ->orderBy('name', 'asc')
            ->get();
    }
}