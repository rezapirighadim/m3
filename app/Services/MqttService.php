<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;
use App\Models\MqttConnection;

class MqttService
{
    public $client;
    protected $connection;
    public $connected = false;

    public function __construct(MqttConnection $connection)
    {
        $this->connection = $connection;
        $this->client = new MqttClient($connection->host, $connection->port, $connection->client_id);
    }

    /**
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     */
    public function connect()
    {


        try {
            $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings);
            $connectionSettings->setUsername($this->connection->username );
            $connectionSettings->setPassword($this->connection->password);
            $this->client->connect($connectionSettings);
            $this->connected = true;
            Log::info('MQTT connection established.');
        } catch (MqttClientException $e) {
            Log::error("MQTT connection failed: " . $e->getMessage());
            $this->connected = false;
            $this->reconnect();
        }

    }


    public function reconnect()
    {
        $attempts = 0;
        while (!$this->connected && $attempts < 5) {
            sleep(5); // Wait before retrying
            $this->connect();
            $attempts++;
        }
    }

    public function disconnect()
    {
        if ($this->connected) {
            $this->client->disconnect();
            $this->connected = false;
        }
    }

    public function checkConnection()
    {
        try {
            $this->connect();
            $this->disconnect();
            return true;
        } catch (MqttClientException $e) {
            Log::error("MQTT connection failed: " . $e->getMessage());
            return false;
        }
    }

    public function publish($topic, $message, $qualityOfService = 0, $retain = false)
    {
        try {
            $this->connect();
            $this->client->publish($topic, $message, $qualityOfService, $retain);
            $this->disconnect();
        } catch (MqttClientException $e) {
            Log::error("MQTT publish failed: " . $e->getMessage());
        }
    }

    public function subscribe($topic, callable $callback, $qualityOfService = 0)
    {
        try {
            $this->connect();
            $this->client->subscribe($topic, $callback, $qualityOfService);
        } catch (MqttClientException $e) {
            Log::error("MQTT subscription failed: " . $e->getMessage());
        }
    }
}
