@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست تراکنش های  ثبت شده</h3>
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
                                <th>شناسه</th>
                                <th class="tac">درگاه</th>
                                <th class="tac">کد پیگیری</th>
                                <th class="tac">مبلغ</th>
                                <th class="tac">زمان ایجاد</th>
                                <th class="tac">زمان پرداخت</th>
                                <th class="tac">شناسه کاربر</th>
                                <th class="tac">ای پی کاربر</th>
                                <th class="tac"> کد authority </th>
                                <th class="tac">نمایش کامل</th>
                                <th class="tac">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($records) && $records!=null){
                            foreach($records as $record){?>
                            <tr class="cat_row">
                                <td><?=$record['id'];?></td>
                                <td class="tac"><?=$record['port_name'];?></td>
                                <td class="tac"><?=$record['reference'];?></td>
                                <td class="tac"><?=$record['total_after_off'];?></td>
                                <td class="tac"><?=jdate('Y/m/d H:i' , $record['creation_time']);?></td>
                                <td class="tac"><?=jdate('Y/m/d H:i' , $record['payment_time']);?></td>
                                <td class="tac"><?=$record['user_id'];?></td>
                                <td class="tac"><?=$record['user_ip'];?></td>
                                <td class="tac"><?=$record['authority'];?></td>
                                <td class="tac">مشاهده</td>
                                <td class="tac">
                                    -
                                </td>
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
