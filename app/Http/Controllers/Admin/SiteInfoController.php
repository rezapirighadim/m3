<?php

namespace App\Http\Controllers\Admin;

use App\Models\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends AdminController
{
    public function index()
    {

        $data['title'] = "اطلاعات سایت";
        $data = array_merge($data, $this->data);
        $data['requestedData'] = SiteInfo::first();
        $data = array_merge($data, $this->data);
        return View('admin.site_info', $data);
    }

    public function store(Request $request)
    {
        $site_info =  SiteInfo::first();
        if (!$site_info) $site_info = new SiteInfo();
        $site_info->about_us =request('about_us');
        $site_info->lat =request('lat');
        $site_info->lang =request('lang');
        $site_info->telegram =request('telegram');
        $site_info->instagram =request('instagram');
        $site_info->image =request('image');
        $site_info->tell =request('tell');
        $site_info->phone =request('phone');

        $site_info->save();

        toast( __('trans.SUBMIT_SUCCESSFULLY'),'success')->width('350')->position('center');
        return redirect('/admin/site_info');
    }
}
