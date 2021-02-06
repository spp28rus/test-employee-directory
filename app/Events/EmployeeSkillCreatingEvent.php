<?php

namespace App\Events;

use App\Models\EmployeeSkill;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmployeeSkillCreatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var EmployeeSkill
     */
    protected $employeeSkill;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EmployeeSkill $employeeSkill)
    {
        $this->employeeSkill = $employeeSkill;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function getEmployeeSkill()
    {
        return $this->employeeSkill;
    }
}
