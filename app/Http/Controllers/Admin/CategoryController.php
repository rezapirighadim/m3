<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends AdminController
{

    public function index()
    {
        $data['records'] = Category::all();;
        $data['title'] = "اساتید";
        $data['path'] = "مدیریت وب سایت / اساتید";

        $data = array_merge($data, $this->data);
        return View('admin.categories', $data);
    }


    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $imageName = null;
        if ($request->input('edit') == 0) {
            $imageName = $this->upload_image($request);

            Category::create([
                'title' => $request['title'],
                'price' => $request['price'],
                'user_id' => Auth::user()->id,
                'similar_title' => str_replace(' ','-' , $request['title'] ),
                'description' => $request['description'],
                'image' => $imageName,
            ]);
            toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
            return back();
        }

        $imageName = Category::where('id', $request->input('edit'))->pluck('image')->first();

        if ($request->hasFile('image')) {
            if ($imageName && file_exists(public_path() . '/uploads/categories/' . $imageName)) {
                unlink(public_path() . '/uploads/categories/' . $imageName);
            }
            $imageName = $this->upload_image($request);
        }

        Category::where('id', $request->input('edit'))
            ->update([
                'title' => $request['title'],
                'price' => $request['price'],
                'user_id' => Auth::user()->id,
                'similar_title' => str_replace(' ','-' , $request['title'] ),
                'description' => $request['description'],
                'image' => $imageName,
            ]);


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

    public function edit(Category $category)
    {
        if ($category == null) {
            return 'inserted url is wrong ';

        }

        $data['title'] = "دسته بندی";
        $data['path'] = "مدیریت وب سایت / دسته بندی";
        $data['records'] = Category::all();;
        $data = array_merge($data, $this->data);
        $data['requestedCategories'] = json_decode($category, true);
        return View('admin.categories', $data);


    }


    public function destroy($id) {
        $category = Category::where('id', $id)->first();
        try{
            $category->delete();
            if ($category->image && file_exists(public_path() . '/uploads/categories/' . $category->image)) {
                unlink(public_path() . '/uploads/categories/' . $category->image);
            }
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }
}
