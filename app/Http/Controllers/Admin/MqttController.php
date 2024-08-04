<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MqttConnection;
use App\Models\Sensor;
use Illuminate\Http\Request;

class MqttController extends AdminController
{
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
}
