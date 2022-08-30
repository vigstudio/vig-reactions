<?php

namespace Botble\VigReactions\Http\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Botble\VigReactions\Models\VigReactions;

class CreateOrUpdateReactionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var VigReactions|false
     */
    public $reaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VigReactions $reaction)
    {
        $this->reaction = $reaction;
    }

}
