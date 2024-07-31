<?php

namespace App\Http\Controllers\Admin;

use App\MobileUser;
use App\Models\OffCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffCodeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = OffCode::whereSeller_id(auth()->user()->id)->get();
        $data['records'] = $records;

        $data['title'] = "کد های تخفیف";

        $data = array_merge($data, $this->data);
        return View('admin.off_codes', $data);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validData = $this->validate($request, [
            'title' => 'required|string|max:255',
            'expire_ts' => 'required',
            'code' => 'required|string|max:255',
            'percent' => 'required|numeric|max:100',
            'max_limit' => 'nullable|numeric',
        ]);


        $request['max_limit'] = (int)$request['max_limit'] ? $request['max_limit'] : null;

        $user_id = null;
        if ($request['phone']){
            $user_id = MobileUser::wherePhone($request['phone'])->pluck('id')->first();
        }

        $request['expire_ts'] = convert2english($request['expire_ts']);

        $request['expire_ts'] = piry_jalali2timestamp_endOfDay($request['expire_ts']);

        $code = strtolower($request['code']);
        if ($request->input('edit') == 0) {


            OffCode::create([
                'title' => $request['title'],
                'user_id' => $user_id,
                'seller_id' => Auth::user()->id,
                'code' => $code,
                'percent' => $request['percent'],
                'max_limit' => $request['max_limit'],
                'expire_ts' => $request['expire_ts'],
            ]);

            toast( ' کد تخفیف با موفقیت ثبت شد ','success')->width('1')->position('center');

        } else {
            OffCode::where('id', $request->input('edit'))->update([
                'title' => $request['title'],
                'user_id' => $user_id,
                'seller_id' => Auth::user()->id,
                'code' => $code ,
                'percent' => $request['percent'],
                'max_limit' => $request['max_limit'],
                'expire_ts' => $request['expire_ts'],
            ]);

            toast( ' بروز رسانی کد تخفیف با موفقیت ثبت شد ','success')->width('1')->position('center');

        }
        myRedirect('/admin/off_codes');

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OffCode $off_code)
    {
        if ($off_code == null) {
            return 'inserted url is wrong ';

        } else {
//            dd($off_code);
            $records = OffCode::whereSeller_id(auth()->user()->id)->get();
            $data['records'] = $records;

            $data['title'] = "کد های تخفیف";
            $off_code['phone'] = null;
            if ($off_code['user_id']){
                $off_code['phone'] = MobileUser::whereId($off_code['user_id'])->pluck('phone')->first();
            }
            $off_code['expire_ts'] = jdate('Y/m/d' , $off_code['expire_ts']);

            $data = array_merge($data, $this->data);
            $data['requestedCategories'] = json_decode($off_code, true);
            return View('admin.off_codes', $data);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            OffCode::where('id', $id)->delete();
        }catch (\Exception $e){
            return $e;
        }
        return $id;
    }
}
