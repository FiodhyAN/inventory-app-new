<?php

namespace App\Events;

use App\Models\Barang;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BarangMasuk
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $barang;
    public $lokasi;

    /**
     * Create a new event instance.
     */
    public function __construct(string $barang, string $lokasi)
    {
        $this->barang = $barang;
        $this->lokasi = $lokasi;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}