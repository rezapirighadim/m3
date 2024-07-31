<?php

namespace App\Http\Controllers\Admin;

use App\MobileUser;
use App\Models\Transaction;
use App\Models\User;

class OrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/admin/orders/new');
    }


    public function get_orders($type = null)
    {
        $records = [] ;
// new orders disabled for now
        if (!$type) $type = 'download';

        $orders = Transaction::query();
        switch ($type){
            case 'new' :
                $records = $orders->wherePayed(1)->get();
                break;
            case 'all' :
                $records = $orders->wherePayed(1)->get();
                break;
            default :
                break;
        }

        $data['title'] = "سفارشات";
        $data['records'] = $records;

        $data = array_merge($data, $this->data);


        return view('admin.orders_list' , $data);

    }


    public function order_details(Transaction $transaction)
    {


        $data['transaction'] = $transaction;
        $data['title'] = "جزییات سفارشات";
        $data['requested_info'] = $transaction;
        $data['requested_user'] = User::whereId($transaction['user_id'])->first();
        $data = array_merge($data, $this->data);

        return view('admin.order_details' , $data);



    }




    public function change_order_status($id){
        toast(  'شما دسترسی لازم را ندارید!','error')->width('1')->position('center');
        return back();
        $order = BookOrder::whereId($id)->whereSeller_id(auth()->user()->id)->first();
        if (!$order){
            toast(  'شما دسترسی لازم برای تغییر وضعیت این سفارش را ندارید.','error')->width('1')->position('center');
            return back();
        }

        if ($order['is_sent']){
            $order->is_sent = null;
            $order->sent_ts = null;
        }else{
            $order->is_sent = 1;
            $order->sent_ts = time();
        }
        $order->save();
        toast(  'تغییر وضعیت سفارش با موفقیت انجام شد.','success')->width('1')->position('center');
        return back();


    }


}
