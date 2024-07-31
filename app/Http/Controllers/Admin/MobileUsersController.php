<?php

namespace App\Http\Controllers\Admin;

use App\Models\MobileUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class MobileUsersController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = " کاربران موبایل ";

        $users = MobileUser::orderBy('id', 'desc')->get();

        $data['users'] = ($users == null ? [] : $users->toArray());
        $data = array_merge($data, $this->data);
        return View('admin.user_list', $data);

    }


    public function info(MobileUser $user)
    {
        $data['requested_user'] = $user;
        $data['guilds'] = [];

        $data['title'] = "اطلاعات کاربران";

        $data = array_merge($data, $this->data);
        return View('admin.user_info', $data);

    }




    public function get_excel(){
        $columnNames = [['نام' , 'نام خانوادگی' ,'شماره موبایل' , 'ایمیل' ,'تاریخ ثبت نام']];
        $rows = MobileUser::orderBy('id', 'desc')->get(['name' ,'family' , 'phone' , 'email' , 'created_at'])->toArray();
        $fileName = auth()->user()->username;

        $content = '';
        $fileName = auth()->user()->id . '_users_csv_' . time() . '_' . $fileName . '.csv';


        try{
            $users_array = array_merge($columnNames , $rows);

            echo "\xEF\xBB\xBF";
            foreach ($users_array as $item){
                $item = array_values($item);
                $content .= implode(",\t",$item) . "\t\n";
            }

//            $content = str_replace(',,' , ',__,' , $content) ;
//            $content = str_replace("\t\n," , "\t\n__," , $content) ;


            Storage::put("csv/" . $fileName, $content);

            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-disposition: " . 'attachment; filename="' . $fileName . '"');
            header("Pragma: " . 'no-cache');
            header("Cache-control: " . 'must-revalidate, post-check=0, pre-check=0');
            header("Expires: 0");
            readfile(storage_path('app/csv/'.$fileName) );
        }catch (\Exception $exception){
            toast( ' خطایی در هنگام دانلود رخ داد. لطفا مجددا امتحان نمایید ','error')->width('1')->position('center');
            return back();
        }
        try{
            Storage::delete("csv/" . $fileName );
        }catch(\Exception $e){

        }


    }

   
}
