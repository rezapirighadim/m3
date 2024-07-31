<?php

namespace App\Http\Controllers\Admin;

use App\Tariff;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use nusoap_client;
use soapclient;

class PaymentController extends Controller
{

    public function pay($id){

        $tariff = Tariff::whereId($id)->get()->first()->toArray();

        $this->iranKishPaymentRequest($tariff);
    }


//    private function irankish_pay($tariff){

    public function iranKishPaymentRequest($info = [] ){



        load_nusoap();
        $merchantId = env('IRANKISH_MERCHANT_ID' , 'A344');
        $order_id = time();
        $wsdl = "https://ikc.shaparak.ir/XToken/Tokens.xml";
        $client = new nusoap_client($wsdl,true);
        $client->soap_defencoding='UTF-8';
        $params['amount'] = $info['discounted_price'];
        $params['merchantId'] = $merchantId;
        $params['invoiceNo'] = $order_id;
        $params['paymentId'] = $order_id;
        $params['revertURL'] = URL::to('/admin/iranKishVerify');
        $result = $client->call("MakeToken", array($params));

        if($result['MakeTokenResult']['result'] == 'true'){
            $info['saleOrderId'] = $order_id;
            $info['authority'] = $result['MakeTokenResult']['token'];
            $info['user_ip'] = get_client_ip();
            $info['port_name'] = 'iran_kish';

            $this->openTransaction($info);

            ?>
            <form id="kicapeyment" action="https://ikc.shaparak.ir/tpayment/payment/Index" method="POST" >
                <input type="hidden" name="token" value="<?php echo $result['MakeTokenResult']['token'] ?>">
                <input type="hidden" name="merchantId" value="<?= $merchantId ?>">
            </form>
            <script>document.forms["kicapeyment"].submit()</script>'
            <?
        }else{
            $data['msg'] = 'خطا در مقادیر ارسال شده به بانک . لطفا مجددا تلاش کنید ' ;
            return view('message.fail' , $data);
            exit;
        }
    }

    private function openTransaction($info){

         DB::table('transactions')->insert([
            'user_id' => auth()->user()->id,
            'type' => 'seller_tariff' ,
            'type_value' => $info['id'],
            'port_name' => $info['port_name'],
            'user_ip' => $info['user_ip'],
            'authority' => $info['authority'],
            'order_id' => $info['saleOrderId'],
            'payed' => 0,
            'price' => $info['price'],
            'total' => $info['price'],
            'total_after_off' => $info['discounted_price'],
            'creation_time' => time(),
        ]);

    }

    private function closeTransaction ($info) {


        DB::table('transactions')->where('order_id' , $info['orderId'])->update([
            'payed' => 1,
            'payment_time' => time() ,
            'reference' => $info['reference'],
            'card_info' => $info['card_holder_info'],
            'card_pan' => $info['card_holder_pan'],
        ]);
        $result = Transaction::whereOrder_id( $info['orderId'] )->first()->toArray();
        $tariff = Tariff::whereId($result['type_value'])->get()->first();

        $days = $tariff->days;
        $book_limit = $tariff->book_limit;
        $add_time = 86400 * $days ;
        $expire_time  = auth()->user()->expire_time;
        $book_limit  += auth()->user()->book_limit;
        $time = 0;
        if($expire_time > time()){
            $remain = $expire_time - time();
            $remain += $add_time;
            $time = $remain + time();
        }else{
            $time = time() + $add_time;
        }


        User::whereId($result['user_id'])->update([
            'expire_time' => $time,
            'book_limit' => $book_limit
        ]);

    }


    public function iranKishVerify(Request $request){


        $request = $request->toArray();

//        [
//            "token" => "48370720194654312862",
//            "merchantId" => "A344",
//            "resultCode" => "499",
//            "paymentId" => "1567773176",
//            "InvoiceNumber" => "1567773176",
//            "hashedCardNo" => "197190190242106110115180248922301492354811921713314788",
//            "referenceId" => "800994782319",
//            "amount" => "1000",
//            "cno" => "OikPvrpG56j1EHe8DKpBTBIyK0OOwCsv",
//            "cardNo" => "603799******9564",
//        ];

        $token = trim($request['token']); // همان توکنی که در مرحله رزرو ساخته شد
        $resultCode = trim($request['resultCode']); // کد برگشت که برای تراکنش موفق عدد 100 میباشد
        $paymentId = trim($request['paymentId']); // همان شناسه خرید که در مرحله ساخت توکن استفاده کردیم
        $referenceId = trim($request['referenceId']); // شناسه مرجع که بانک میسازه و قابل پیگیری هست
        $merchantId = trim($request['merchantId']);

        if($resultCode == '100'){
            load_nusoap();
            $wsdl = "https://ikc.shaparak.ir/XVerify/Verify.xml";
            $client = new nusoap_client($wsdl,true);
            $client->soap_defencoding='UTF-8';
            $params['token'] = $token;
            $params['merchantId'] = $merchantId; // مرچند کد
            $params['referenceNumber'] = $referenceId;
            $params['sha1Key'] = '22338240992352910814917221751200141041845518824222260';
            $result = $client->call("KicccPaymentsVerification", array($params));


            if ($result['KicccPaymentsVerificationResult'] ==  trim($request['amount']) ) // شرط برابری قیمت تراکنش رزرو شده و پرداخت شده
            {

                $info['orderId']            = $paymentId;
                $info['authority']          = $token;
                $info['reference']          = $referenceId;
                $info['card_holder_info']   = $request['hashedCardNo'];
                $info['card_holder_pan']    = $request['cardNo'];


                $this->closeTransaction($info);

                $data['msg'] = 'پرداخت موفقیت آمیز بود . کد رهگیری :' . $info['reference'] ;
                return view('message.success' , $data);


            } else {
                $data['msg'] = 'فرآیند پرداخت با خطا مواجه شد.  در صورت کسر وجه از حساب شما، مبلغ مذکور طی 72 ساعت به حساب شما عودت داده خواهد شد . ';
                return view('message.fail' , $data);
            }
        }else{
            $data['msg'] = 'فرآیند پرداخت با خطا مواجه شد . ' ;
            return view('message.fail' , $data);


        }

    }


}


