<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VerifyCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function new_login(Request $request) {
        // Validation Data
        $validData = $this->validate($request, [
            'phone'    => 'required|string|max:14|min:10',
        ]);


        if(!checkPhone($validData['phone']))
            return myResponse('fail' ,[] ,'شماره وارد شده اشتباه است.' );

        $code = VerifyCode::wherePhone($request['phone'])->where('ts' , '>' , time() - env('RESEND_SMS_TIME_S' , 300) )->first();
        if ($code) return myResponse('fail' , [] , 'از آخرین درخواست شما باید ' . env('RESEND_SMS_TIME_S' , 300)/60 . ' دقیقه گذشته باشد .');
        $token = rand(10000 , 99999);

        VerifyCode::create([
                'phone' => $request['phone'],
                'ts' => time(),
                'code' => $token,
                'expire_ts' => time() + env('RESEND_SMS_TIME_S' , 300)
            ]);

            $url = 'https://api.kavenegar.com/v1/' . env('KAVENEGAR_APIKEY') . '/verify/lookup.json?receptor=' . $validData['phone'] . '&token=' . $token . '&template=login' ;
            $message_detail =  null;
            try{
                $message_detail =  json_decode(file_get_contents($url) , true);
            }catch (\Exception $e ){
                $message_detail = json_decode(curl($url) , true);
            }

            $user = User::updateOrCreate(['phone' => $validData['phone'] ],[
                'phone'     => $validData['phone'],
                'email'     => $validData['phone'] . '@'.'gmail.com',
                'password'  => bcrypt(''),
            ]);

        return myResponse('success' , [] , 'کد ورود به شماره تلفن شما ارسال شد .');
    }

    public function check_login(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|numeric' ,
            'phone' => 'required'
        ]);
        $code = VerifyCode::wherePhone($request['phone'])->whereCode($request['code'])->where('ts' , '>' , time() - env('RESEND_SMS_TIME_S' , 300))->first();
        if (!$code)
            return myResponse('fail' , [] ,'کد وارد شده اشتباه است.' );

        $user = User::wherePhone($request['phone'])->first();

        if (isset($user->tokens[0])) $user->tokens[0]->delete();

        $access_token = $user->createToken('login token')->accessToken;

        return myResponse('success' , new UserResource($user , $access_token) );
    }

    public function edit_profile(Request $request){
        $validData = $this->validate($request , [
            'name' => 'required|string',
            'email' => 'email|nullable',
        ]);
        $email = $request['email'] ? $request['email'] : null;

        User::whereId(auth()->user()->id)->update([
            'name' => $validData['name'],
            'email' => $email,
        ]);

        return responseStructure('success', '' , 'اطلاعات پروفایل تکمیل شد.');

    }

    public function getUserInformation() {

        return myResponse('success',auth()->user() );
    }

    public function resend_register_code(Request $request){
        $validData = $this->validate($request, [
            'phone'       => 'required'
        ]);

        $code = VerifyCode::wherePhone($request['phone'])->where('ts' , '>' , time() - env('RESEND_SMS_TIME_S' , 300) )->first();
        if ($code) return myResponse('fail' , [] , 'از آخرین درخواست شما باید ' . env('RESEND_SMS_TIME_S' , 300)/60 . ' دقیقه گذشته باشد .');
        $token = rand(10000 , 99999);

        VerifyCode::create([
            'phone' => $request['phone'],
            'ts' => time(),
            'code' => $token,
            'expire_ts' => time() + env('RESEND_SMS_TIME_S' , 300)
        ]);

        $url = 'https://api.kavenegar.com/v1/' . env('KAVENEGAR_APIKEY') . '/verify/lookup.json?receptor=' . $validData['phone'] . '&token=' . $token . '&template=login' ;
        $message_detail =  null;
        try{
            $message_detail =  json_decode(file_get_contents($url) , true);
        }catch (\Exception $e ){
            $message_detail = json_decode(curl($url) , true);
        }

        return myResponse('success' , [] , 'کد ورود به شماره تلفن شما ارسال شد .');

    }

    public function get_user_accessed_categories(Request $request)
    {
        $user = User::whereId(auth()->user()->id)->first();
        $user->categories()->get()->all();
        return myResponse('success' , $user->categories()->get()->all());
    }


    public function logout(Request $request){

        auth()->user()->token()->delete();

        return myResponse('success', '' , 'اعتبار توکن باطل شد.');

    }

    public function get_user_transactions(Request $request)
    {
        $transactions = Transaction::whereUser_id(auth()->user()->id)->get(['order_id' , 'reference' , 'payed' , 'creation_time' , 'payment_time' , 'total_after_off as price']);
        return myResponse('success' , $transactions );
    }
}
