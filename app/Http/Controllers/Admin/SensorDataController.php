<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SensorData;

class SensorDataController extends AdminController
{
    public function index()
    {
        $data['records'] = SensorData::all();;
        $data['title'] = "سنسور";
        $data['path'] = "مدیریت وب سایت / سنسور";

        $data = array_merge($data, $this->data);
        return View('admin.sensor_datas', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'name' => 'required|string|max:255',
            'uuid' => 'required',
        ]);

        $sensor = Sensor::find($request->input('edit') );
        if (!$sensor) $sensor = new Sensor();

        $sensor->name = $request['name'];
        $sensor->uuid = $request['uuid'];
        $sensor->version = $request['version'];
        $sensor->description = $request['description'];
        $sensor->save();

        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return back();

    }

    private function upload_image($request){
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPathImg = public_path() . '/uploads/categories/';
            $time = time();
            if (!$image->move($destinationPathImg,$time . $image->getClientOriginalName())) {
                return 'Error saving the file.';
            }
            $imageName = $time . $image->getClientOriginalName();
        }
        return $imageName;
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
