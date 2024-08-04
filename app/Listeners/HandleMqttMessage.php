<?php

namespace App\Listeners;

use App\Events\MqttMessageReceived;
use App\Models\MqttMessage;
use App\Models\Variable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
        Log::info("Received MQTT message on topic {$event->topic}: {$event->message}");

        // Store the received message in the database
        MqttMessage::create([
            'topic' => $event->topic,
            'message' => $event->message,
        ]);

        $message = json_decode($event->message, true);

        // Get all variables that match the sensor_id (assuming the topic contains sensor_id)
        $sensorId = $event->topic;

        $variables = Variable::where('sensor_id', $sensorId)->get();

        foreach ($variables as $variable) {
            foreach ($variable->alert_index as $alert) {
                $this->checkAndLogAlert($message, $alert);
            }
        }
    }


    private function checkAndLogAlert($message, $alert)
    {
        $index = $alert['index'];
        $threshold = $alert['threshold'];

        // Use dot notation to get the value from the nested message array
        $value = $this->getValueFromIndex($message, $index);

        if ($value !== null && $value > $threshold) {
            Log::info("Alert: {$index} value {$value} exceeds threshold {$threshold}");
        }
    }

    private function getValueFromIndex($array, $index)
    {
        $keys = explode('.', $index);
        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return null;
            }
            $array = $array[$key];
        }
        return $array;
    }
}
