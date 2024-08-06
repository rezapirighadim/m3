<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device_data;
use App\Models\MqttMessage;

class MqttMessageController extends AdminController
{
    public function index()
    {
        $data['records'] = Device_data::all();;
        $data['title'] = "داده های دریافت شده از MQTT";
        $data['path'] = "مدیریت وب سایت / داده های دریافتی";

        $data = array_merge($data, $this->data);
        return View('admin.mqtt_messages', $data);
    }

}
