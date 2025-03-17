<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeleted implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskId;

    public function __construct($taskId) {
        $this->taskId = $taskId;
    }

    public function broadcastOn(): array {
        return [
            new Channel('tasks'),
        ];
    }

    public function broadcastAs() {
        return 'task.deleted';
    }
}
