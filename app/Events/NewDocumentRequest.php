<?php

namespace App\Events;

use App\Models\DocumentRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewDocumentRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;

    public function __construct(DocumentRequest $document)
    {
        $this->document = $document;
    }

    public function broadcastOn()
    {
        return new Channel('document-channel');
    }

    public function broadcastAs()
    {
        return 'new-document';
    }
}
