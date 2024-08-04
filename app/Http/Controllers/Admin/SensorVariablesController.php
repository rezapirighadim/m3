<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Models\Variable;
use Illuminate\Http\Request;

class SensorVariablesController extends AdminController
{
    public function index()
    {
        $data['records'] = Variable::with('sensor')->get();;
        $data['title'] = "متغییرهای سنسور";
        $data['path'] = "مدیریت وب سایت / متغییرهای سنسور";
        $data['sensors'] = Sensor::all();

        $data = array_merge($data, $this->data);
        return View('admin.sensor_variables', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'sensor_id' => 'required|numeric|exists:sensors,id|unique:variables,sensor_id,' . $request['edit'] ,
            'variables' => 'required|array',
        ]);

        $variablesJson = $this->convertVariables($request['variables']);

        $variable = Variable::find($request->input('edit') );
        if (!$variable) $variable = new Variable();

        $variable->sensor_id = $request['sensor_id'];
        $variable->alert_index = json_encode($variablesJson);
        $variable->save();

        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return back();

    }


    public function edit(Variable $variable)
    {
        if ($variable == null) {
            return 'inserted url is wrong ';
        }

        $data['records'] = Variable::with('sensor')->get();;
        $data['title'] = "متغییرهای سنسور";
        $data['path'] = "مدیریت وب سایت / متغییرهای سنسور";
        $data['sensors'] = Sensor::get();
        $data['requestedData'] = $variable ;
        $data = array_merge($data, $this->data);
        return View('admin.sensor_variables', $data);

    }


    public function destroy($id) {
        $category = Variable::find($id);
        try{
            $category->delete();
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }

    private function convertVariables($variables): array
    {
        $variables = array_values($variables);
        foreach ($variables as $key => $variable){
            if (!$variable['index'] || !$variable['threshold']){
                unset($variables[$key]);
            }
        }

        return array_values($variables);
    }
}
