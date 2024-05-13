<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $creatorID;
    public $taskID;
    public $receivers;
    public $date;
    public $content;
    public $taskTitle;
    public $url;
    public function __construct($creatorID, $taskID, $receivers, $date, $content, $taskTitle, $url)
    {
        //
        $this->creatorID = $creatorID;
        $this->taskID = $taskID;
        $this->receivers = $receivers;
        $this->date = $date;
        $this->content = $content;
        $this->taskTitle = $taskTitle;
        $this->url = $url;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'notification-channel'
        ];
    }
    public function broadcastAs()
    {
        return 'notification-event';
    }
}
