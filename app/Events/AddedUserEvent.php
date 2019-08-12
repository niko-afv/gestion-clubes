<?php

namespace App\Events;

use App\Contracts\ILog;
use App\Member;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddedUserEvent extends LogEvent implements ILog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $tipoLog = 16;

    public function __construct(User $object)
    {
        $this->object = $object;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getTipoLog(){
        return $this->tipoLog;
    }
}
