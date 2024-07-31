@extends('admin.theme.main')
@section('content')
    @if (auth()->user()->role == 'seller')

        <div class="row">

            <div class="col-md-6">
                <p class="alert alert-info"> مدت زمان باقی مانده اعتبار استفاده از پنل :

                    <span class="red-color red">
                    {{
                        auth()->user()->expire_time > time() ? round((auth()->user()->expire_time - time()) / 86400) . ' روز ' :  'تمام شده'
                    }}

                    </span>
                </p>
            </div>
            <div class="col-md-6">
                <p class="alert alert-success"> دسترسی به نشر ( ناشران ) :

                    <span class="red-color red">
                        {{
                        empty($publishers) ? 'x' : implode(' - ' , $publishers)
                        }}
                    </span>
                </p>
            </div>


        </div>
        @if (round((auth()->user()->expire_time - time()) / 86400) <= 15)
               <div class="row">
                   <div class="col-md-12">

                       <h1 class="tac">تعرفه ها</h1>

                       <hr>
                       <p class="alert alert-danger"> مدت زمان استفاده از پنل شما رو به اتمام است . لطفا برای جلو گیری از مسدود شدن امکانات پنل مدیریت و کارکرد اپلیکیشن نسبت به خرید یکی از تعرفه ها زیر اقدام کنید . </p>
                       <br>
                   </div>
               </div>

        <div class="row">
            @foreach($tariffs as $tariff)
                <div class="col-md-6">
                    <div style="background-color:{{$tariff['color']}} ; border-radius: 20px !important;">
                        <div style="background-color: white ; margin : 0px 10px ; padding: 30px 50px;">
                            <h1 class="tac">{{$tariff['title']}}</h1>
                            <hr>
                            <p>{{$tariff['description']}}</p>
                            <hr>
                            <p>محدودیت کتاب : {{number_format($tariff['book_limit'])}}  </p>
                            <p>قیمت اصلی : {{number_format($tariff['price'])}} ریال </p>
                            <p>قیمت بعد از تخفیف : {{number_format($tariff['discounted_price'])}} ریال </p>
                            <hr>
                            <br>
                            <a href="{{URL::to('/admin/payTariff/' . $tariff['id'])}}" target="_blank" class="btn btn-info btn-block">پرداخت</a>
                        </div>
                    </div>
                    <br>
                </div>

            @endforeach
        </div>

    @else

        <div class="row">
            <div class="col-md-12" >

                <div style="padding: 10px">

                    <payment-component :values="{{ json_encode($values) }}" :labels="{{ json_encode($labels) }}"></payment-component>
                </div>

            </div>
            <div class="col-md-12">
                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                    <div class="pie-widget">
                        <div id="pie-widget-1" class="chart-pie-widget" data-percent="{{get_percent($book_count , $book_limit )}}">
                            <span class="pie-widget-count-1 pie-widget-count"></span>
                        </div>
                        <div style="margin-right: 30px ;margin-top: 20px;">
                            <p class="tar"> کتب مجاز :‌ <span class="red">{{$book_limit}}</span> </p>
                            <p class="tar">تعداد کل کتب :‌ <span class="red">{{$book_count}}</span> </p>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                    <div class="pie-widget">
                        <div id="pie-widget-2" class="chart-pie-widget" data-percent="{{get_percent($book_count , $free_book )}}">
                            <span class="pie-widget-count-2 pie-widget-count"></span>
                        </div>
                        <div style="margin-right: 30px ;margin-top: 20px;">
                            <p class="tar"> تعداد کتب رایگان :‌ <span class="red">{{$free_book}}</span> </p>
                            <p class="tar">تعداد کتب غیر رایگان :‌ <span class="red">{{$book_count - $free_book}}</span> </p>
                        </div>

                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                    <div class="pie-widget">
                        <div id="pie-widget-3" class="chart-pie-widget" data-percent="{{get_percent($book_count , $book_content_count )}}">
                            <span class="pie-widget-count-3 pie-widget-count"></span>
                        </div>
                        <div style="margin-right: 30px ;margin-top: 20px;">
                            <p class="tar"> تعداد کتب بامحتوا :‌ <span class="red">{{$book_content_count}}</span> </p>
                            <p class="tar">تعداد کتب بدون محتوا :‌ <span class="red">{{$book_count - $book_content_count}}</span> </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                    <div class="pie-widget">
                        <div id="pie-widget-4" class="chart-pie-widget" data-percent="{{get_percent($app_install , $user_count )}}">
                            <span class="pie-widget-count-4 pie-widget-count"></span>
                        </div>
                        <div style="margin-right: 30px ;margin-top: 20px;">
                            <p class="tar"> تعداد نصب اپلیکیشن :‌ <span class="red">{{$app_install}}</span> </p>
                            <p class="tar">تعداد ثبت نام کنندگان :‌ <span class="red">{{$user_count}}</span> </p>
                        </div>


                    </div>
                </div>
            </div>


        </div>

    @endif
    @endif

@endsection
