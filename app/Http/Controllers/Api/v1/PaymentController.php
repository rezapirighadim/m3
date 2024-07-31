<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OffCode;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PaymentController extends Controller
{
    public function pay(Request $request , $return_price = false)
    {
        $this->validate($request , [
            'packages'    => 'required|json',
            'categories'  => 'required|json'
        ]);

        $packages_id = json_decode($request['packages'] , true);
        $cats = notNullUnique(json_decode($request['categories'] , true));
        $packages = Package::whereIn('id' , $packages_id)->get();
        $p_cats = [] ;
        if ($packages->toArray())
            foreach ($packages as $key => $value)
                $p_cats[$key]= ($value->categories()->pluck('id')->all());

        $p_cats = array_values(array_filter($p_cats)) ;
        $temp = [] ;
        foreach ($p_cats as $cat)
            $temp = array_merge($temp , $cat);

        $packages_cats = array_values(array_unique($temp));


        $packages_price = Package::whereIn('id' , $packages_id)->pluck('price')->all();
        $packages_price = array_sum($packages_price);
        $packages_cats = notNullUnique($packages_cats);

        $all_cats = array_merge($packages_cats , $cats);
        $cats_price =  Category::whereIn('id' , $cats)->pluck('price')->all();
        $cats_price = array_sum($cats_price);
        $total_price_after_off = $total_price = $before_off = $cats_price + $packages_price ;
        if ($request['off_code']) $total_price_after_off = $this->apply_discount($request['off_code'] , $total_price);
        if ($return_price) return $total_price_after_off;

//        return [$packages_price , $cats_price , $total_price];
        $order_id = time() . '-' . rand(1000 , 9999);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id ,
            'merchant_id' => env('ZARINPAL_MERCHANT' , '-') ,
            'category_ids' => $request['categories'] ,
            'all_cat_ids' => implode('#',$all_cats) ,
            'package_ids' => $request['packages'] ,
            'port_name' => 'zarinpal' ,
            'authority' => '' ,
            'order_id' => $order_id ,
            'reference' => '' ,
            'payed' => 0 ,
            'off_code' => $request['off_code'] ,
            'off_price' => '' ,
            'total' => $total_price ,
            'total_after_off' => $total_price_after_off ,
            'creation_time' => time() ,
        ]);

        return $this->generate_link($request , $transaction);




    }

    public function generate_link($request , $transaction)
    {
        $transaction_id = $transaction->id ;
        $timestamp = Carbon::now()->addMinute(5)->timestamp;
        $hash = Hash::make(env('APP_DOWNLOAD_SALT') . $transaction_id  . $timestamp);

        return url("/api/v1/pay/$transaction_id?mac=$hash&t=$timestamp");
    }

    public function calculate_off_code(Request $request)
    {
        $this->validate($request , [
            'off_code' => 'required|exists:off_codes,code',
            'packages'    => 'required|json',
            'categories'  => 'required|json'
        ]);
        $price = $this->pay($request , true);
        return myResponse('success' , ['after_off' => $price]);
    }

    private function apply_discount($off_code, $total_price)
    {
        $off_code = OffCode::whereCode($off_code)->first();
        if (!$off_code) return $total_price ;
        $after_off = $total_price - ($total_price * $off_code->percent / 100 );
        $after_off = floor($after_off);
        if ($off_code->max_limit){
            $after_off = ($total_price - $after_off) > $off_code->max_limit ? $total_price - $off_code->max_limit : $after_off;
        }
        return $after_off;
    }

    public function send_to_bank($transaction_id , Request $request)
    {
        if ($request['t'] < time()) return redirect(env('FRONT_URL') . '/#/fail?message=لینک منقضی شده است . مجدد تلاش کنید .') ;
        $transaction = Transaction::find($transaction_id);
        if (!$transaction) return redirect(env('FRONT_URL') . '/#/fail?message=لینک خراب است . مجدد تلاش کنید .') ;

        $CallbackURL =  url('/api/v1/verify_payment');
        $order_id = $transaction->order_id;

        $data = array("merchant_id" => env('ZARINPAL_MERCHANT'),
//            "amount" => $transaction->total_after_off,
            "amount" => 1000,
            "callback_url" => url('/api/v1/verify_payment'),
            "description" => "خرید از سایت حنین قرآن",
        );
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        curl_close($ch);



        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if (empty($result['errors'])) {
                if ($result['data']['code'] == 100) {
                    $transaction->authority = $result['data']["authority"] ;
                    $transaction->save();
                    myRedirect('https://zarinpal.com/pg/StartPay/' . $result['data']["authority"]);
                }
            } else {
                echo 'Error Code: ' . $result['errors']['code'];
                echo 'message: ' . $result['errors']['message'];

            }
        }

    }

    public function verify_payment(Request $request)
    {
        $Authority = $request['Authority'];
        $data = array("merchant_id" => env('ZARINPAL_MERCHANT') , "authority" => $Authority, "amount" => 1000);
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $transaction = Transaction::whereAuthority($request['Authority'])->first();
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if (isset($result['data']) && isset($result['data']['code']) && ($result['data']['code'] == 100 ||  $result['data']['code'] == 101)) {
                $transaction->payed = true ;
                $transaction->payment_time = time();
                $transaction->reference = $result['data']['ref_id'];
                $transaction->save();
                $this->generate_access($transaction);
                return redirect(env('FRONT_URL') . '/#/success?message=پرداخت با موفقیت انجام شد . کد رهگیری : ' . $result['data']['ref_id']) ;
            } else {
                return redirect(env('FRONT_URL') . '/#/fail?message=' . $result['errors']['message']) ;
            }

        }
    }

    private function generate_access($transaction)
    {
        $user = User::find($transaction->user_id);
        $cat_ids = $transaction->all_cat_ids ;
        $cat_ids = explode('#' , $cat_ids);
        $user_current_access = $user->categories()->pluck('id')->all();
        $all_cat_ids  = array_merge(array_values($user_current_access) , $cat_ids);
        $user->categories()->sync($all_cat_ids);
        return true;
    }


}
