<?php

namespace App\Events;

use App\Http\Requests\UpdateJobStatusRequest;
use App\Models\Job;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Job $job;

    private UpdateJobStatusRequest $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, UpdateJobStatusRequest $request)
    {
        $this->job = $job;
        $this->request = $request;
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
     * @return Job
     */
    public function getJob(): Job
    {
        return $this->job;
    }

    public function getUser(): User
    {
        return $this->request->getUser();
    }
}
