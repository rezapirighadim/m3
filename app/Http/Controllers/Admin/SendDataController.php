<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MqttConnection;
use App\Models\Sensor;
use App\Services\MqttService;
use Illuminate\Http\Request;

class SendDataController extends AdminController
{
    public function index()
    {
        $data['records'] = Sensor::all();;
        $data['title'] = "ارسال داده";
        $data['path'] = "مدیریت وب سایت / ارسال داده";

        $data = array_merge($data, $this->data);
        return View('admin.send_data', $data);
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


}
