<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionContorller extends AdminController
{

    public function list($type){

        if (auth()->user()->role == 'admin')
            return $this->admin_list($type);

        if (auth()->user()->role == 'seller')
            return $this->seller_list($type);

    }
    private function admin_list($type){
        $records = [] ;
        if ($type == 'success')
            $records = Transaction::whereType('seller_tariff')->wherePayed(1)->get()->toArray();
        else if ($type == 'fail')
            $records = Transaction::whereType('seller_tariff')->wherePayed(0)->get()->toArray();


        $data['records'] = $records;
        $data = array_merge($data, $this->data);
        return View('admin.transactions_list', $data);
    }

    private function seller_list($type){
        $records = [] ;
        if ($type == 'success')
            $records = Transaction::wherePayed(1)->whereSeller_id(auth()->user()->id)->wherePayed(1)->get()->toArray();
        else if ($type == 'fail')
            $records = Transaction::wherePayed(0)->whereSeller_id(auth()->user()->id)->wherePayed(0)->get()->toArray();


        $data['records'] = $records;
        $data = array_merge($data, $this->data);
        return View('admin.transactions_list', $data);
    }
}
