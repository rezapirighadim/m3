@extends('admin.theme.main')
@section('content')


    <div class="row">
    <div class="col-md-12">

                    <?$user = $requested_user ?>

                        <div class="alert alert-{{$requested_info['is_payed'] ? 'success' : 'warning'}}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            هرینه این سفارش توسط کاربر پرداخت <span>{{$requested_info['is_payed'] ? 'شده است' : 'نشده است'}}</span>
                        </div>

                        <div class="panel panel-dark">
                            <div class="panel-heading">
                                <h3 class="panel-title">محصولات خریداری شده</h3>
                            </div>
                            <div class="panel-body">
                                <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                    <table  class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>شناسه</th>
                                            <th>نام کتاب</th>
                                            <th>تعداد</th>
                                            <th>قیمت هر کتاب</th>
                                            <th>قیمت کل</th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?
                                        if(isset($baskets) && $baskets != null){
                                        $books_price = 0 ;
                                        foreach($baskets as $basket){?>
                                        <tr class="cat_row">
                                            <td>{{ $basket['id'] }}</td>
                                            <?$bookTitle = $basket->book()->first()->title?>
                                            <td class=""><a href="/admin/books/{{$basket['book_id']}}">{{mb_strlen($bookTitle ) > 80 ? $bookTitle  = mb_substr($bookTitle , 0, 77) . '...' : $bookTitle }}</a></td>
                                            <td>{{ $basket['count'] }} عدد </td>
                                            <td>{{ $basket->book()->first()->price }} ریال </td>
                                            <td>{{ $books_price += (integer)$basket->book()->first()->price * (integer)$basket['count'] }} ریال </td>
                                        </tr>
                                        <?}}?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                   <div class="row">
                       <div class="col-lg-6">

                           <div class="panel panel-primary">
                               <div class="panel-heading">
                                   <h3 class="panel-title">جزییات مالی</h3>
                               </div>
                               <div class="panel-body">
                                   <p class="hoverP2"> <span class="info-label-2"> تاریخ پرداخت :</span> <span class="info-body-2">{{jdate('Y/m/d ساعت H:i:s' , $transaction['payment_time'])}}</span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> درگاه پرداخت :</span> <span class="info-body-2">{{$transaction['port_name']}}</span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">کد تخفیف :</span> <span class="info-body-2"><?=(check_var($transaction['off_code'])? $transaction['off_code'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">درصد تخفیف :</span> <span class="info-body-2"><?=(check_var($transaction['off_percent'])? $transaction['off_percent'] . ' ٪ ' : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">هزینه کتب :</span> <span class="info-body-2">{{$books_price}} ریال </span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">مبلغ تخفیف :</span> <span class="info-body-2"><?=(check_var($transaction['off_price'])? $transaction['off_price'] . ' ریال ' : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">مبلغ استفاده شده از اعتبار :</span> <span class="info-body-2"><?=(check_var($transaction['used_credit'])? $transaction['used_credit'] : "0 ریال " )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> هزینه پستی :</span> <span class="info-body-2"><?=(check_var($requested_info['sent_price']) ? $requested_info['sent_price'] . ' ریال ' : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> مبلغ کل :</span> <span class="info-body-2"><?=(check_var($transaction['total_after_off'])? $transaction['total_after_off']  . ' ریال ' : "وارد نشده" )?></span> </p>
                               </div>
                           </div>

                       </div>
                       <div class="col-lg-6 col-md-6 col-sm-12">
                           <div class="panel panel-primary">
                               <div class="panel-heading">
                                   <h3 class="panel-title">اطلاعات گیرنده سفارش</h3>
                               </div>
                               <div class="panel-body">
                                   <p class="hoverP2"> <span class="info-label-2"> نحوه ارسال :</span> <span class="info-body-2">{{$requested_info['sent_type']}}</span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> نام گیرنده :</span> <span class="info-body-2">{{$user['name'] . ' ' . $user['family']}}</span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">استان :</span> <span class="info-body-2"><?=(check_var($address['province'])? $address['province'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">شهر :</span> <span class="info-body-2"><?=(check_var($address['city'])? $address['city'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">آدرس  :</span> <span class="info-body-2"><?=(check_var($address['address'])? $address['address'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> کد پستی :</span> <span class="info-body-2"><?=(check_var($address['post_nm']) ? $address['post_nm'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2"> موبایل :</span> <span class="info-body-2"><?=(check_var($address['phone'])? $address['phone'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">شماره ثابت :</span> <span class="info-body-2"><?=(check_var($address['tell'])? $address['tell'] : "وارد نشده" )?></span> </p>
                                   <p class="hoverP2"> <span class="info-label-2">موقعیت روی نقشه :</span> <span class="info-body-2"><?=$address['lat'] ? '<a href="http://maps.google.com/maps?z=12&t=m&q=loc:'. $address['lat'] . '+'. $address['long'] .'">مشاهده بر بروی نقشه<a/>' : 'ثبت نشده'?> </span> </p>
                               </div>
                           </div>
                       </div>
                   </div>
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel panel-dark">
                                <div class="panel-heading">
                                    <h3 class="panel-title">تغییر وضعیت سفارش</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="ls_form" role="form" action="{{ URL::to('admin/change_order_status') }}" method="post" >
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>تغییر وضعیت</label>
                                                    <select id="select_user" name="status" multiple  class="demo-default" placeholder="جستجو و انتخاب وضعیت">
                                                        <?foreach ($statuses as $record){?>
                                                        <option value="<?=$record['id'] . '###' . $record['title']?>"><?=$record['title']?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                                <div class="form-group">

                                                    <label>توضیحات مختصر</label>
                                                    <textarea name="description" class="form-control" placeholder="توضیحات مختصر (اختیاری)" rows="3" maxlength="190"></textarea>
                                                    {!! csrf_field() !!}
                                                    <input name="user_id" value="{{$transaction['user_id']}}" type="hidden">
                                                    <input name="order_id" value="{{$requested_info['id']}}" type="hidden">

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" >
                                                        <label class="checkbox">
                                                            <input name="notification"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                                            <span> اطلاع رسانی به کاربر </span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-sm btn-warning btn-block" style="height: 35px;"> ثبت تغییرات </button>
                                                </div>

                                            </div>


                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="panel panel-dark">
                                <div class="panel-heading">
                                    <h3 class="panel-title"> تاریخچه وضعیت سفارش </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                        <table  class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>وضعیت</th>
                                                <th>توضیحات</th>
                                                <th>تاریخ</th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <?if (isset($statuses) && isset($statuses[0])){?>

                                            <tr class="cat_row">
                                                <td>{{ $statuses[0]['title'] }}</td>
                                                <td>-</td>
                                                <td>{{jdate('Y/m/d ساعت H:i:s' , $transaction['payment_time'])}}</td>
                                            </tr>

                                            <?}?>
                                            <?if(isset($order_statuses) && $order_statuses != null){
                                            foreach($order_statuses as $order_status){?>
                                            <tr class="cat_row">
                                                <td>{{ $order_status['status'] }}</td>
                                                <td>{{ $order_status['description'] }}</td>
                                                <td>{{jdate('Y/m/d ساعت H:i:s' , $order_status['ts'])}}</td>
                                            </tr>
                                            <?}}?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <h3 class="panel-title">اطلاعات ثبت نامی کاربر</h3>
                                </div>
                                <div class="panel-body">
                                    <p class="hoverP"> <span class="info-label"> شناسه کاربری :</span> <span class="info-body"> <?=$user['id']?></span> </p>
                                    <p class="hoverP"> <span class="info-label">نام  :</span> <span class="info-body"><?=(check_var($user['name'])? $user['name'] : "وارد نشده" )?></span> </p>
                                    <p class="hoverP"> <span class="info-label"> نام خانوادگی :</span> <span class="info-body"><?=(check_var($user['family'])? $user['family'] : "وارد نشده" )?></span> </p>
                                    <p class="hoverP"> <span class="info-label">شماره موبایل :</span> <span class="info-body"><?=(check_var($user['phone'])? $user['phone'] : "وارد نشده" )?></span> </p>
                                    <p class="hoverP"> <span class="info-label">تاریخ ثبت نام :</span> <span class="info-body"><?=piry_gregorian_to_jalali($user['created_at']);?></span> </p>
                                    <p class="hoverP"> <span class="info-label">ایمیل :</span> <span class="info-body"><?=(check_var($user['email'])? $user['email'] : "وارد نشده" )?></span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                    </div>

                    <br>
                    <div class="col-md-12">

                    </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".tooltipLink").tooltip({
            animation: true
        });
        $(".popoverBox").popover({
            animation: true
        });
    });

    function my_confirm() {
        if (confirm("آیا مطمعن هستید؟"))
            return true;
        else
            return false;
    }
</script>
@endsection
