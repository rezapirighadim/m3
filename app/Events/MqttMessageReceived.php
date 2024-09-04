<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MqttMessageReceived
{
    use Dispatchable, SerializesModels;

    public $topic;
    public $message;
    public $sensor_id;

    public function __construct($sensor_id ,$topic, $message)
    {
        $this->topic = $topic;
        $this->message = $message;
        $this->sensor_id = $sensor_id;
    }
}
