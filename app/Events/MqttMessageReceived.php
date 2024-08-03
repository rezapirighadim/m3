<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MqttMessageReceived
{
    use Dispatchable, SerializesModels;

    public $topic;
    public $message;

    public function __construct($topic, $message)
    {
        $this->topic = $topic;
        $this->message = $message;
    }
}
