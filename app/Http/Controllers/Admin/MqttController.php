<?php

namespace App\Http\Controllers\Admin;

use App\Events\MqttMessageReceived;
use App\Http\Controllers\Controller;
use App\Models\MqttConnection;
use App\Models\Sensor;
use App\Services\MqttService;
use Illuminate\Http\Request;

class MqttController extends AdminController
{

    protected $mqttService;

    public function __construct()
    {
        $this->mqttService = null;
        parent::__construct();

    }

    public function index()
    {
        $data['records'] = MqttConnection::query()->first();;
        $data['title'] = " اتصال به MQTTT";
        $data['path'] = "مدیریت وب سایت /  اتصال به MQTTT";

        $data['requestedDatas'] = MqttConnection::query()->first();;
        $data = array_merge($data, $this->data);
        return View('admin.mqtt', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'client_id' => 'required|string|max:255',
            'host' => 'required',
            'port' => 'required|numeric',
        ]);

        $connection = MqttConnection::query()->first();
        if (!$connection) $connection = new MqttConnection();

        $connection->client_id = $request['client_id'];
        $connection->host = $request['host'];
        $connection->port = $request['port'];
        $connection->username = $request['username'];
        $connection->password = $request['password'];
        $connection->save();

        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return back();

    }
    public function publish(Request $request)
    {
        $connection = MqttConnection::first(); // Assuming you have one connection entry

        if (!$connection) {
            return response()->json(['status' => 'MQTT connection details not found'], 404);
        }

        $this->mqttService = new MqttService($connection);

        $topic = $request->input('topic');
        $message = $request->input('message');

        $this->mqttService->publish($topic, $message);

        return response()->json(['status' => 'Message published']);
    }

    public function subscribe()
    {
        $connection = MqttConnection::first(); // Assuming you have one connection entry

        if (!$connection) {
            return response()->json(['status' => 'MQTT connection details not found'], 404);
        }

        $this->mqttService = new MqttService($connection);

        $this->mqttService->subscribe('test/topic', function ($topic, $message) {
            event(new MqttMessageReceived($topic, $message));
        });

        return response()->json(['status' => 'Subscribed to topic']);
    }

    public function checkConnection()
    {
        $connection = MqttConnection::first();; // Assuming you have one connection entry

        if (!$connection) {
            return response()->json(['status' => 'MQTT connection details not found'], 404);
        }

        $this->mqttService = new MqttService($connection);

        $isConnected = $this->mqttService->checkConnection();

        return response()->json(['status' => $isConnected ? 'Connected' : 'Connection failed']);
    }
}
