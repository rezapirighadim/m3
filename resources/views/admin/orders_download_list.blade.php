@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست سفارشات فیزیکی  ثبت شده</h3>
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
                                <th class="tac">شناسه تراکنش</th>
                                <th class="tac">عنوان کتاب</th>
                                <th class="tac">کد پیگیری پرداخت</th>
                                <th class="tac">مبلغ</th>
                                <th class="tac">زمان پرداخت</th>
                                <th class="tac">خریدار</th>
                                <th class="tac">نمایش کامل</th>
                                <th class="tac">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($records) && $records!=null){
                            foreach($records as $record){?>
                            <?$bookTitle = $record->book()->first()->title?>

                            <tr class="cat_row">
                                <td>{{$record['id']}}</td>
                                <td class=""><a href="/admin/books/{{$record['type_value']}}">{{mb_strlen($bookTitle ) > 80 ? $bookTitle  = mb_substr($bookTitle , 0, 77) . '...' : $bookTitle }}</a></td>
                                <td class="tac">{{$record['reference']}}</td>
                                <td class="tac">{{$record['total_after_off']}} تومان </td>
                                <td class="tac">{{jdate('Y/m/d H:i' , $record['payment_time'])}}</td>
                                <?  $info =  \App\MobileUser::whereId($record['user_id'])->first(['name' , 'family']);
                                    $info = $info ? $info->toArray() : [];
                                 ?>
                                <td class="tac"><a href="/admin/mobile_users/{{$record['user_id']}}">{{implode(' ', $info )}}</a></td>
                                <td class="tac">مشاهده</td>
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
