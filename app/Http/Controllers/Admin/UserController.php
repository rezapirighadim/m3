<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('Admin.users.all' , compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }


    public function change_password(){

        $data['path'] = "تغییر رمز عبور ";
        $data['title'] = " تغییر رمز عبور ";

        return View('admin.change_password', $data);
    }
    public function change_password_store(Request $request) {
        $data['path'] = "تغییر رمز عبور ";
        $data['title'] = " تغییر رمز عبور ";


        $validData = $this->validate($request, [
            'currentPassword' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:6',
            'password_confirmation' => 'required|string|max:255|min:6|same:password',
        ]);

        if(Hash::check($request['currentPassword'],Auth::user()->password)) {
            User::where( 'id' , Auth::user()->id )->update([
                'password' => bcrypt($request['password'])
            ]);
            toast(  ' پسورد شما با موفقیت تغییر یافت . لطفا یک بار از سیستم خارج و مججدا لاگین کنید . ','success')->width('1')->position('center');
            return back();
        }else{
            toast( 'پسورد فعلی وارد شده اشتباه است .  مجددا تلاش نمایید.','error')->width('1')->position('center');
            return back();
        }


        return view('admin.change_password', $data);
    }

}
