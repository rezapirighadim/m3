@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست سفارشات فیزیکی ثبت شده</h3>
        </div>
        <div class="panel-body">
            <section class="row component-section">

                <!-- responsive table title and description -->

                <!-- responsive table code and example -->
                <div class="col-md-12">
                    <!-- responsive table example -->
                    <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                        <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>شماره سفارش</th>
                                <th class="tac">شناسه تراکنش</th>
                                <th class="tac">کد پیگیری پرداخت</th>
                                <th class="tac">مبلغ</th>
                                <th class="tac">زمان ایجاد</th>
                                <th class="tac">زمان پرداخت</th>
                                <th class="tac">شناسه کاربر</th>
                                <th class="tac">نمایش کامل</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($records) && $records!=null){
                            foreach($records as $record){?>
                            <tr class="cat_row">
                                <td>{{$record['id']}}</td>
                                <td class="tac">{{$record['order_id']}}</td>
                                <td class="tac">{{$record['reference']}}</td>
                                <td class="tac">{{$record['total_after_off']}} تومان </td>
                                <td class="tac">{{jdate('Y/m/d H:i' , $record['creation_time'])}}</td>
                                <td class="tac">{{jdate('Y/m/d H:i' , $record['payment_time'])}}</td>
                                <td class="tac"><a href="/admin/mobile_users/{{$record['user_id']}}">{{implode(' ',\App\Models\User::whereId($record['user_id'])->first(['name'])->toArray() )}}</a></td>
                                <td class="tac">-</td>
                            </tr>
                            <?}}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </section>



        </div>
    </div>
    <script>

    </script>
@endsection
