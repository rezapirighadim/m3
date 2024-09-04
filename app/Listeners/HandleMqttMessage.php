<?php

namespace App\Listeners;

use App\Events\MqttMessageReceived;
use App\Models\Device;
use App\Models\Device_data;
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
    private $device_id = null;

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


        $message = isJson($event->message) ? json_decode($event->message, true) : $event->message;

        $sensorId = $event->sensor_id;
        $variables = Variable::where('sensor_id', $sensorId)->first();

        if ($variables){
            $this->handleIfVariablesSettled($variables , $message , $event);
        }

        $device_data = new Device_data();
        $device_data->topic = $event->topic;
        $device_data->sensor_id = $event->topic;
        $device_data->device_id = $this->device_id;
        $device_data->received_data = is_array($message) ? json_encode($message) : $message;

        $device_data->save();

    }


    private function handleIfVariablesSettled($variables , $message , $event)
    {
        $alert_index = $variables->alert_index;
        if (!is_array($variables->alert_index)) {
            try {
                $alert_index = json_decode($variables->alert_index, true);
            } catch (\Exception $e) {

            }
        }

        $alertTriggered = false;

        $uuid = $this->getValueFromIndex($message, $variables->uuid_index);
        $device = $this->createDevice($uuid);
        $this->device_id = $device->id;
        foreach ($alert_index as $alert) {
            if ($this->checkAndLogAlert($message, $alert)) {
                $alertTriggered = true;
            }
        }

        if ($variables->publish_json) {
            $json = json_decode($variables->publish_json);
            $json['server_message'] = $alertTriggered ? 'Alert triggered' : 'Every thing is OK!';
            $json['alert_triggered'] = $alertTriggered;
            $json['uuid'] = $uuid;
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

    private function getValueFromIndex($message, $index)
    {
        $uuid = '' ;
        if (!is_array($message)) return $uuid;
        $keys = explode('.', $index);
        foreach ($keys as $key) {
            if (!isset($message[$key])) {
                return null;
            }
            $message = $message[$key];
        }
        return $message;
    }

    private function createDevice($uuid)
    {
        if (!$uuid) return null;
        $device = Device::where('uuid', $uuid)->first();
        if (!$device) {
            $device = Device::query()->create(['uuid' => $uuid]);
        }
        return $device;
    }

}
