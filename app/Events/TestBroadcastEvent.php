<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function broadcastOn(): Channel
    {
        // قناة عامة للتج
        return new Channel('test-channel');
    }

    public function broadcastWith(): array // يلي بدنا نبعتو لفلاتر
    {
        return [
            'message' => 'Hello from Laravel via Pusher!',
        ];
    }
}
