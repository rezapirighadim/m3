<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Content;
use App\Models\Package;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function get_categories(Request $request)
    {
        return myResponse(
            'success',
            Category::all()
        );
    }


    public function get_home()
    {
        $categories = Category::all();
        $packages = Package::all();
        $banners = Banner::all();
        $site_info = SiteInfo::first();
        $free_content = array_merge(Content::where('free' , true)->with('files')->get()->toArray() ,  Content::where('free' , false)->get()->toArray());
        return myResponse('success' , get_defined_vars());
    }

    public function get_site_info()
    {
        $site_info = SiteInfo::first();
        return myResponse('success' , $site_info );

    }

    public function get_packages()
    {
        return myResponse('success' , Package::all());
    }
    public function get_packages_by_category(Request $request)
    {
        $this->validate($request , [
            'category_id' => 'required'
        ]);
        return myResponse('success' , Package::whereCategory_id($request['category_id'])->get());
    }

    public function free_content_by_category(Request $request){
        $this->validate($request , [
            'category_id' => 'required|numeric|exists:categories,id'
        ]);
        $free_contents = Content::where('free' , true)->with('files')->whereCategory_id($request['category_id'])->get()->toArray();
        $not_free_contents = Content::where('free' , false)->whereCategory_id($request['category_id'])->get()->toArray();
        $contents = array_merge($free_contents , $not_free_contents);
        return myResponse('success' , $contents);
    }

    public function like_content(Request $request)
    {
        $this->validate($request , [
            'content_id' => 'required|exists:contents,id'
        ]);
        $content = Content::find($request['content_id']);
        $content->like_count +=1;
        $content->save();
        return myResponse('success' , $content);
    }

    public function get_shop(Request $request)
    {
        $packages = Package::get(['id' , 'title' , 'price']);
        $categories = Category::get(['id' , 'title' , 'price']);
        return myResponse('success' , ['packages' => $packages , 'categories' => $categories]);

    }

}
