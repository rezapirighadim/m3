<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MqttService;
use App\Models\MqttConnection;
use App\Events\MqttMessageReceived;
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

        try {
            $this->mqttService->connect();
            $this->info('MQTT connection established.');

            $this->mqttService->subscribe('test/topic', function ($topic, $message) {
                event(new MqttMessageReceived($topic, $message));
            });

            // Keeping the script running
            while (true) {
                $this->mqttService->client->loop(true); // Listen for messages
            }
        } catch (MqttClientException $e) {
            $this->error('MQTT connection failed: ' . $e->getMessage());
        }
    }
}
