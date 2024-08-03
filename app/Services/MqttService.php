<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;
use App\Models\MqttConnection;

class MqttService
{
    protected $client;

    public function __construct(MqttConnection $connection)
    {
        $this->client = new MqttClient($connection->host, $connection->port, $connection->client_id);
        $this->client->connect($connection->username, $connection->password);
    }

    public function publish($topic, $message, $qualityOfService = 0, $retain = false)
    {
        try {
            $this->client->publish($topic, $message, $qualityOfService, $retain);
        } catch (MqttClientException $e) {
            // Handle exception
        }
    }

    public function subscribe($topic, callable $callback, $qualityOfService = 0)
    {
        try {
            $this->client->subscribe($topic, $callback, $qualityOfService);
            $this->client->loop(true);
        } catch (MqttClientException $e) {
            // Handle exception
        }
    }

    public function disconnect()
    {
        $this->client->disconnect();
    }
}
