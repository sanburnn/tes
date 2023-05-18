<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Belanja implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pengajuan;
    public $recipient_role;

    /**
     * Create a new event instance.
     *
     * @param  array  $pengajuan
     * @param  string  $recipient_role
     * @return void
     */
    public function __construct($pengajuan, $recipient_role)
    {
        $this->pengajuan = $pengajuan;
        $this->recipient_role = $recipient_role;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PrivateChannel|array
     */
    public function broadcastOn()
    {
        $users = User::role($this->recipient_role)->get();
        $channels = [];

        foreach ($users as $user) {
            $channels[] = new PrivateChannel('pengajuan.' . $user->id);
        }

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'pengajuan' => $this->pengajuan,
            'recipient_role' => $this->recipient_role,
        ];
    }
}
