<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use Illuminate\Console\Command;
use App\Services\MqttService;
use App\Models\MqttConnection;
use App\Events\MqttMessageReceived;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\MqttClientException;

class ListenToMqtt extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to MQTT messages';

    protected $mqttService;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $connection = MqttConnection::find(1); // Ensure there's an entry in the database

        if (!$connection) {
            $this->error('MQTT connection details not found.');
            return;
        }

        $this->mqttService = new MqttService($connection);

        while (true) {
            try {
                $this->mqttService->connect();
                $this->info('MQTT connection established.');

                $sensors = Sensor::query()->whereNotNull('receive_topic')->get();
                foreach ($sensors as $sensor){
                    $this->mqttService->subscribe($sensor->receive_topic ,  function ($topic, $message) use($sensor) {
                        event(new MqttMessageReceived($sensor->id , $topic, $message));
                    });
                }

                while ($this->mqttService->connected) {
                    $this->mqttService->client->loop(true); // Listen for messages
                }
            } catch (MqttClientException $e) {
                $this->error('MQTT connection failed: ' . $e->getMessage());
                Log::error('MQTT connection failed: ' . $e->getMessage());
                sleep(1); // Wait before attempting to reconnect
            }
        }
    }
}
