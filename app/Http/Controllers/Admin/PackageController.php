<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Content;
use App\Models\Master;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends AdminController
{

    public function index()
    {
        $data['allContents'] = Content::all();;
        $data['records'] = Package::all();;
        $data['categories'] = Category::all();;
        $data['title'] = "پکیج ها";
        $data['path'] = "مدیریت وب سایت / پکیج ها";

        $data = array_merge($data, $this->data);
        return View('admin.packages', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'title'         => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'image'         => 'nullable|mimes:jpg,bmp,png,jpeg',
            'categories'    => 'required',

        ]);
        $package = new Package();
        $imageName = null ;
        if ($request['edit']){
            $package = Package::find($request['edit']);
            $imageName = $package->image;
        }

        if ($request->hasFile('image')){
            if ($imageName && file_exists(public_path() . '/uploads/packages/' . $imageName) )
                unlink(public_path() . '/uploads/packages/' . $imageName);
            $imageName = $this->upload_image($request);
        }

        $package->title = $request['title'];
        $package->description = $request['description'];
        $package->image = $imageName;
        $package->available = $request['available'] ? 1 : 0 ;
        $package->price = $request['price'];
        $package->save();

        $package->categories()->sync($request['categories']);

        toast(  'با موفقیت ثبت شد.','success')->width('400')->position('center');
        return redirect("/admin/package/{$package->id}");

    }

    public function edit(Package $package)
    {
        $data['allContents'] = Content::all();;
        $data['records'] = Package::all();
        $data['title'] = "پکیج ها";
        $data['path'] = "مدیریت وب سایت / پکیج ها";
        $data['categories'] = Category::all();;
        $package_categories = $package->getContentIdsAttribute()->toArray();
        $package = $package->toArray();
        $package['categories'] = $package_categories;
        $data['requestedData'] = $package ;
        $data = array_merge($data, $this->data);
        return View('admin.packages', $data);

    }

    private function upload_image($request){
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPathImg = public_path() . '/uploads/packages/';
            $time = time();
            if (!$image->move($destinationPathImg,$time . $image->getClientOriginalName())) {
                return 'Error saving the file.';
            }
            $imageName = $time . $image->getClientOriginalName();
        }
        return $imageName;
    }


    public function destroy($id) {
        $package = Package::where('id', $id)->first();
        try{
            $package->delete();
            if ($package->image && file_exists(public_path() . '/uploads/packages/' . $package->image)) {
                unlink(public_path() . '/uploads/packages/' . $package->image);
            }
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }
}
