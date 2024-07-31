<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MastersController extends AdminController
{

    public function index()
    {
        $data['records'] = Master::all();;
        $data['title'] = "اساتید";
        $data['path'] = "مدیریت وب سایت / اساتید";

        $data = array_merge($data, $this->data);
        return View('admin.masters', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('edit') == 0) {
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPathImg = base_path() . '/public/uploads/masters/';
                $time = time();
                if (!$image->move($destinationPathImg,$time . $image->getClientOriginalName())) {
                    return 'Error saving the file.';
                }
                $imageName = $time . $image->getClientOriginalName();
            }

            Master::create([
                'name' => $request['name'],
                'birthday' => $request['birthday'],
                'death_day' => $request['death_day'],
                'description' => $request['description'],
                'picture' => $imageName,
            ]);


        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                $last_image = Master::where('id', $request->input('edit'))->first()['picture'];
                if ($last_image &&  file_exists(base_path() . '/public/uploads/masters/' . $last_image)) {
                    unlink(base_path() . '/public/uploads/masters/' . $last_image);
                }
                $image = $request->file('image');
                $destinationPathImg = base_path() . '/public/uploads/masters/';
                if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
                    return 'Error saving the file.';
                }
                $imageName = $image->getClientOriginalName();
                Master::where('id', $request->input('edit'))
                    ->update([
                        'name' => $request['name'],
                        'birthday' => $request['birthday'],
                        'death_day' => $request['death_day'],
                        'description' => $request['description'],
                        'picture' => $imageName,
                    ]);
            } else {

                $imageName = Master::where('id', $request->input('edit'))->pluck('picture');
                $imageName = $imageName[0];
                if ($request->hasFile('image')) {

                    if (file_exists(base_path() . '/public/uploads/masters/' . $imageName)) {
                        unlink(base_path() . '/public/uploads/masters/' . $imageName);
                    }

                    $image = $request->file('image');
                    $destinationPathImg = base_path() . '/public/uploads/masters/';
                    if (!$image->move($destinationPathImg, $image->getClientOriginalName())) {
                        return 'Error saving the file.';
                    }
                    $imageName = $image->getClientOriginalName();
                }

                Master::where('id', $request->input('edit'))->update([
                    'name' => $request['name'],
                    'birthday' => $request['birthday'],
                    'death_day' => $request['death_day'],
                    'description' => $request['description'],
                    'picture' => $imageName,
                ]);
            }
        }
        return myRedirect('/admin/masters');

    }

    public function edit(Master $master)
    {
        if ($master == null) {
            return 'inserted url is wrong ';

        } else {

            $data['records'] = Master::all();
            $data['title'] = "اساتید";
            $data['path'] = "مدیریت وب سایت / اساتید";

            $data = array_merge($data, $this->data);
            $data['requestedCategories'] = json_decode($master, true);
            return View('admin.masters', $data);

        }
    }


    public function destroy($id) {
        $image_name = Master::where('id', $id)->pluck('picture')->first();
        try{
            Master::where('id', $id)->delete();
            if ($image_name  && file_exists(base_path() . '/public/uploads/masters/' . $image_name)) {
                unlink(base_path() . '/public/uploads/masters/' . $image_name);
            }
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }
}
