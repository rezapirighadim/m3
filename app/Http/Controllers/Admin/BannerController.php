<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Publisher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Banner::all();
        $data['records'] = $records;


        $data['title'] = "بنرها";
        $data['path'] = "مدیریت وب سایت / بندر ها";

        $data = array_merge($data, $this->data);
        return View('admin.banners', $data);
    }



    public function store(Request $request)
    {
        $validData = $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        $imageName = null;
        if ($request->input('edit') == 0) {
            $imageName = $this->upload_image($request);

            Banner::create([
                'title' => $request['title'],
                'link' => $request['link'],
                'description' => $request['description'],
                'position' => $request['position'],
                'image' => $imageName,
            ]);
            toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
            return back();
        }

        $imageName = Banner::where('id', $request->input('edit'))->pluck('image')->first();

        if ($request->hasFile('image')) {
            if ($imageName && file_exists(public_path() . '/uploads/banners/' . $imageName)) {
                unlink(public_path() . '/uploads/banners/' . $imageName);
            }
            $imageName = $this->upload_image($request);
        }

        Banner::where('id', $request->input('edit'))
            ->update([
                'title' => $request['title'],
                'link' => $request['link'],
                'description' => $request['description'],
                'position' => $request['position'],
                'image' => $imageName,
            ]);


        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return back();

    }


    private function upload_image($request){
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPathImg = public_path() . '/uploads/banners/';
            $time = time();
            if (!$image->move($destinationPathImg,$time . $image->getClientOriginalName())) {
                return 'Error saving the file.';
            }
            $imageName = $time . $image->getClientOriginalName();
        }
        return $imageName;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Banner $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {

        $data['records'] = Banner::all();;
        $data['title'] = "بنرها";
        $data['path'] = "مدیریت وب سایت / بندر ها";


        $data = array_merge($data, $this->data);
        $data['requestedCategories'] = $banner ;

        return View('admin.banners', $data);


    }

    public function destroy($id) {
        $banner = Banner::where('id', $id)->first();
        try{
            $banner->delete();
            if ($banner->image && file_exists(public_path() . '/uploads/banners/' . $banner->image)) {
                unlink(public_path() . '/uploads/banners/' . $banner->image);
            }
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }

}
