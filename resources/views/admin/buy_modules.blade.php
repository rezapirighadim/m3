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
                <p class="alert alert-success"> تعداد کتب قابل دسترس شما :

                    <span class="red-color red">
                        {{$seller_limit}}
                    </span>
                </p>
            </div>


        </div>
               <div class="row">
                   <div class="col-md-12">

                       <h1 class="tac">تعرفه ها</h1>

                       <hr>
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


    @endif

@endsection
