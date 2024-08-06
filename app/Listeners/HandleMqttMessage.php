<?php

namespace App\Listeners;

use App\Events\MqttMessageReceived;
use App\Models\MqttConnection;
use App\Models\MqttMessage;
use App\Models\Variable;
use App\Services\MqttService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\MqttClientException;

class HandleMqttMessage
{
    protected $mqttService;

    /**
     * @throws ConnectingToBrokerFailedException
     * @throws ConfigurationInvalidException
     */
    public function __construct()
    {
        $connection = MqttConnection::first();
        $this->mqttService = new MqttService($connection);
    }

    /**
     * Handle the event.
     *
     * @param MqttMessageReceived $event
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

        $variables = Variable::where('sensor_id', $sensorId)->first();

        $alert_index = $variables->alert_index;
        if (!is_array($variables->alert_index)) {
            try {
                $alert_index = json_decode($variables->alert_index, true);
            } catch (\Exception $e) {

            }
        }

        $alertTriggered = false;
        foreach ($alert_index as $alert) {
            if ($this->checkAndLogAlert($message, $alert)) {
                $alertTriggered = true;
            }
        }


        if ($variables->publish_json) {
            $json = json_decode($variables->publish_json);
            $json['server_message'] = $alertTriggered ? 'Alert triggered' : 'Every thing is OK!';
            $json['alert_triggered'] = $alertTriggered;
            $server_message = json_encode($json);
            $this->sendSuccessMessage($event->topic, $server_message);
        }

    }

    private function sendSuccessMessage($topic, $server_message)
    {
        try {
            $this->mqttService->publish($topic . '/response', $server_message);
        } catch (MqttClientException $e) {
            Log::error('Failed to send MQTT success message: ' . $e->getMessage());
        }
    }

    private function checkAndLogAlert($message, $alert): bool
    {
        $index = $alert['index'];
        $threshold = $alert['threshold'];

        // Use dot notation to get the value from the nested message array
        $value = $this->getValueFromIndex($message, $index);

        if ($value !== null && $value > $threshold) {
            Log::info("Alert: {$index} value {$value} exceeds threshold {$threshold}");
            return true;
        }
        return false;
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
