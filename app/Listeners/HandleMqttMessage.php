<?php

namespace App\Listeners;

use App\Events\MqttMessageReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleMqttMessage
{
    /**
     * Handle the event.
     *
     * @param  MqttMessageReceived  $event
     * @return void
     */
    public function handle(MqttMessageReceived $event)
    {
        // Process the received MQTT message
        // For example, log the message or save it to the database
        \Log::info("Received MQTT message on topic {$event->topic}: {$event->message}");
    }
}
