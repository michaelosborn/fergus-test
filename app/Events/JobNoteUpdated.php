<?php

namespace App\Events;

use App\Models\JobNote;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobNoteUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private JobNote $jobNote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(JobNote $updatedJobNote)
    {
        $this->jobNote = $updatedJobNote;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return JobNote
     */
    public function getJobNote(): JobNote
    {
        return $this->jobNote;
    }
}
