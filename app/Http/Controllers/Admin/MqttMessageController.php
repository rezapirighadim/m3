<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
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
    }    public function alerts()
    {
        $data['records'] = Alert::all();;
        $data['title'] = "هشدار های دریافت شده از MQTT";
        $data['path'] = "مدیریت وب سایت / هشدار های دریافتی";

        $data = array_merge($data, $this->data);
        return View('admin.mqtt_alerts', $data);
    }

}
