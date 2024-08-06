<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\SensorData;

class DeviceController extends AdminController
{
    public function index()
    {
        $data['records'] = Device::all();;
        $data['title'] = "سخت افزار های متصل به سامانه";
        $data['path'] = "مدیریت وب سایت / سخت افزار ها";

        $data = array_merge($data, $this->data);
        return View('admin.devices', $data);
    }

}
