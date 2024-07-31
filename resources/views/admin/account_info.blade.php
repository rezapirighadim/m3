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
                        <h3 class="panel-title">اطلاعات شرکت</h3>
                    </div>
                    <div class="panel-body">


                        <p class="form-group">
                            <label>نام شرکت</label>
                            <input value="{{check_var($record['company_name'])}}"  placeholder="نام شرکت" name="company_name" class="form-control " type="text">
                        </p>
                        <p class="form-group">
                            <label>سال تاسیس</label>
                            <input value="{{check_var($record['company_year'])}}"  placeholder="سال تاسیس شرکت" name="company_year" class="form-control " type="text">
                        </p>
                        <p class="form-group">
                            <label>شماره ثبت</label>
                            <input value="{{check_var($record['company_code'])}}"  placeholder="شماره ثبت شرکت" name="company_code" class="form-control " type="text">
                        </p>
                        <p class="form-group">
                            <label>مدیر عامل</label>
                            <input value="{{check_var($record['company_ceo'])}}"  placeholder="مدیر عامل شرکت" name="company_ceo" class="form-control " type="text">
                        </p>
                        <p class="form-group">
                            <label>آدرس شرکت</label>
                            <textarea  placeholder="آدرس شرکت" name="address" class="form-control " type="text">{{check_var($record['address'])}}</textarea>
                        </p>

                    </div>
                </div>

                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h3 class="panel-title">انتخاب موقعیت خود از روی نقشه</h3>
                    </div>
                    <div class="panel-body">


                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>طول جغرافیایی</label>
                                    <input id="long" value="{{check_var($record['long'])}}"  name="long"  class="form-control ltr mono_font" placeholder="Longitude">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عرض جغرافیایی</label>
                                    <input id="lat" value="{{check_var($record['lat'])}}" name="lat"  class="form-control ltr mono_font" placeholder="Latitude">

                                </div>
                            </div>

                            <div id="map" style="width: 100%; height: 500px;;"></div>
                        </div>

                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h3 class="panel-title">اطلاعات تماس با شما</h3>
                    </div>
                    <div class="panel-body">
                        <hr>
                        <p class="form-group">
                            <label>شماره تماس (ثابت)</label>
                            <input placeholder="02188665544" value="{{check_var($record['tell'])}}" name="tell" class="form-control mono_font ltr" type="text">
                        </p>
                        <p class="form-group">
                            <label>شماره فکس </label>
                            <input placeholder="02188665544" value="{{check_var($record['fax'])}}" name="fax" class="form-control mono_font ltr" type="text">
                        </p>
                        <p class="form-group">
                            <label>آدرس وب سایت</label>
                            <input placeholder="https://www.mayamey.com" value="{{check_var($record['website'])}}" name="website" class="form-control mono_font ltr" type="text">
                        </p>

                        <p class="form-group">
                            <label>آی دی صفحه اینستاگرام</label>
                            <input placeholder="https://instagram.com/mayamey_com" value="{{check_var($record['instagram'])}}" name="instagram" class="form-control mono_font ltr" type="text">
                        </p>

                        <p class="form-group">
                            <label>آی دی کانال تلگرام</label>
                            <input placeholder="https://t.me/mayamey_com" value="{{check_var($record['telegram'])}}" name="telegram" class="form-control mono_font ltr" type="text">
                        </p>

                        <p class="form-group">
                            <label>آدرس ایمیل</label>
                            <input placeholder="info@mayamey.com" value="{{check_var($record['email'])}}" name="email" class="form-control mono_font ltr" type="text">
                        </p>

                        <p class="form-group">
                            <label>درباره شرکت</label>
                            <textarea  placeholder="درباره شرکت" rows="7" name="about" class="form-control " type="text">{{check_var($record['about'])}}</textarea>
                        </p>


                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">اطلاعات اعتبار نامه</h3>
                    </div>
                    <div class="panel-body">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>متاتگ های شما</label>
                                    <textarea name="meta_data" rows="7" class="form-control ltr mono_font" placeholder="در صورت لوزم متاتگ های  مورد نظر خود را در این قسمت وارد کنید">{{$record['meta_data']}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>کد اینماد </label>
                                    <textarea name="enemad" rows="7" class="form-control ltr mono_font" >{{$record['enemad']}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>کد ساماندهی</label>
                                    <textarea name="samandehi" rows="7" class="form-control ltr mono_font" >{{$record['samandehi']}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>کد گوگل آنالیتیکس</label>
                                    <textarea name="google_analytics" rows="7" class="form-control ltr mono_font" placeholder="">{{$record['google_analytics']}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>کد گوگل وب مستر</label>
                                    <textarea name="google_webmaster" rows="7" class="form-control ltr mono_font" placeholder="">{{$record['google_webmaster']}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success btn-block" style="height: 35px;">ثبت تغییرات</button>
                </div>

            </div>


        </form>
    </div>

    <script>
        $(document).ready(function () {

//            -------------------------------    map   ----------------------------------
            var lat = 35.7202954;
            var long = 51.40522090000002;

            <?
                if(isset($record['lat'])){?>
                lat = {{$record['lat']}};
            long = {{$record['long']}};
                <?}
                ?>


            var myLatLng = {lat: parseFloat(lat), lng: parseFloat(long)};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'selected location'
            });

            //    ------------------------------


            var mapOptions = {
                zoom: 14 ,
                center: new google.maps.LatLng(lat,long),
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };


            google.maps.event.addListener(map, 'click', function(event) {
                if (marker==null) {
                    marker = new google.maps.Marker({
                        position : event.latLng,
                        map: map
                    });
                } else {
                    marker.setPosition(event.latLng);
                }

                lat = event.latLng.lat();
                long = event.latLng.lng();

                $('#lat').val(lat);
                $('#long').val(long);

            });


            //    ------------------------------


            $("#insert_selected_location").off("click").on("click", function (event) {

                $(element).val('(' + lat.toFixed(6) + ',' + long.toFixed(6) + ')');
                stop_modal();

            });
//            -------------------------------    map   ---------------------------------

        });
    </script>

@endsection
