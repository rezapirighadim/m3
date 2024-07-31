@extends("admin.theme.main")
@section('content')

    <div class="row">
        <form role="form" class="ls_form" method="post" action="/admin/setting">
            {!! csrf_field() !!}
            <div class="col-md-12">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h3 class="panel-title">تنظیمات پرداختی اپلیکیشن</h3>
                    </div>
                    <div class="panel-body">


                        <p class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            در صورت اشتباه وارد کردن مرچنت ایدی درگاه ٬  هیچ مسولیتی درقبال تراکنش ها نخواهد داشت.
                        </p>
                        <p class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            در صورتی که هم مرچنت آی دی ایران کیش و هم مرچنت آی دی زرین پال را وارد کنید اولویت با درگاه ایران کیش میباشد
                        </p>
                            <p class="form-group">
                                <label>شناسه درگاه بانکی ایران کیش (مرچنت آی دی)</label>
                                <input value="{{check_var($record['irankish_merchant_id'])}}" style="font-family: monospace" placeholder="merchant id" name="irankish_merchant_id" class="form-control ltr" type="text">
                            </p>

                        <hr>

                        <p class="form-group">
                            <label>شناسه درگاه زرین پال (مرچنت آی دی)</label>
                            <input value="{{check_var($record['zarinpal_merchant_id'])}}" style="font-family: monospace" placeholder="merchant id" name="zarinpal_merchant_id" class="form-control ltr" type="text">
                        </p>

                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success btn-block" style="height: 35px;">ثبت تغییرات</button>
                </div>


            </div>
            <div class="col-md-6">

                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h3 class="panel-title">شماره شبا</h3>
                    </div>
                    <div class="panel-body">


                        <p class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            در صورتی که دارای درگاه پرداختی نمیباشید پرداختی های کاربران شما به صورتی آنی به حساب شما توسط شماره شبا واریز خواهد شد.
                        </p>
                        <p class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            در صورتی که شبای خود را اشتباه وارد کنید  هیچ مسولیتی در قبال پرداختی ها را به عهده نخواهد داشت.
                        </p>
                        <p class="form-group">
                            <label>شماره شبا</label>
                            <input  style="font-family: monospace" placeholder="IR290170000000444497498001" value="{{check_var($record['shaba_no'])}}"  name="shaba_no" class="form-control ltr" type="text">
                        </p>
                        <p class="form-group">
                            <label>مالک شماره شبا</label>
                            <input placeholder="رضا پیری قدیم" value="{{check_var($record['shaba_bank_name'])}}" name="shaba_bank_name" class="form-control " type="text">
                        </p>
                        <p class="form-group">
                            <label>نام بانک (برای شماره شبا)</label>
                            <input placeholder="بانک ملی" value="{{check_var($record['shaba_bank_for'])}}" name="shaba_bank_for" class="form-control " type="text">
                        </p>

                    </div>
                </div>


            </div>


        </form>
    </div>

@endsection
