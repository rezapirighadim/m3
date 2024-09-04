<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends AdminController
{
    public function index()
    {
        $data['records'] = Sensor::all();;
        $data['title'] = "سنسور";
        $data['path'] = "مدیریت وب سایت / سنسور";

        $data = array_merge($data, $this->data);
        return View('admin.sensors', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $sensor = Sensor::find($request->input('edit') );
        if (!$sensor) $sensor = new Sensor();

        $sensor->name = $request['name'];
        $sensor->version = $request['version'];
        $sensor->receive_topic = $request['receive_topic'];
        $sensor->response_topic = $request['response_topic'];
        $sensor->description = $request['description'];
        $sensor->save();

        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return back();

    }


    public function edit(Sensor $sensor)
    {
        if ($sensor == null) {
            return 'inserted url is wrong ';
        }

        $data['title'] = "سنسور";
        $data['path'] = "مدیریت وب سایت / سنسور";
        $data['records'] = Sensor::all();;
        $data = array_merge($data, $this->data);
        $data['requestedSensors'] = json_decode($sensor, true);
        return View('admin.sensors', $data);

    }


    public function destroy($id) {
        $category = Sensor::find($id);
        try{
            $category->delete();
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }
}
