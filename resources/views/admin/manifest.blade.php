@extends('admin.theme.main')
@section('content')
    <script>
        $(document).ready(function () {
            document.getElementById("uploadBtn").onchange = function () {
                document.getElementById("uploadFile").value = this.value;
            };
            $("#uploadBtn").change(function(){
//            alert("a");
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


    </script>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">تنظیمات وب اپلیکیشن</h3>
            </div>
            <div class="panel-body">
                <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                <?=(isset($error) ? "<p class=\"alert alert-danger\">$error</p>" : "")?>

                <form class="ls_form" role="form" action="{{ URL::to('admin/manifest') }}" enctype="multipart/form-data" method="post">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <p class="alert alert-info">ابعاد ایکون انتخاب شده باید 512x512 پیکسل باشد.</p>
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
                    <div class="col-lg-6 col-sm-12">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نام برنامه</label>
                                    <input name="name" class="form-control" value="{{$manifest['name']}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نام مختصر برنامه</label>
                                    <input name="short_name" class="form-control" value="{{($manifest['short_name'])}}"  >
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 15px;;">
                                <div class="fileUpload btn btn-info">
                                    <span>انتخاب آیکون وب اپ</span>
                                    <input id="uploadBtn" type="file" name="icon" class="upload" accept="image/png"/>
                                </div>
                                <input class="form-control" id="uploadFile" type="text" placeholder="نام فایل انتخاب شده" disabled>
                                <input name="lastImageName" type="hidden" value="{{$manifest['icon']}}">
                            </div>

                        </div>


                    </div>
                    <div class="col-lg-6 ">

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>رنگ المان ها</label>
                                    <input name="background_color" class="form-control tal" style='direction: ltr' onkeyup="$('#color_preview').css('background-color' , '#' + this.value)" placeholder="e933ef" value="{{ $manifest['background_color'] }}">

                                </div>
                                <div class="col-md-6">
                                    <label> پیشنمایش رنگ اتنخاب شده </label>
                                    <div id="color_preview" style="border : 1px dashed #ccc ; background-color: #{{$manifest['background_color']}} ; height:35px ; width: 100%;"></div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>رنگ زمینه</label>
                                    <input name="theme_color" class="form-control tal" style='direction: ltr' onkeyup="$('#color_preview_2').css('background-color' , '#' + this.value)" placeholder="e933ef" value="{{($manifest['theme_color'])}}">

                                </div>
                                <div class="col-md-6">
                                    <label> پیشنمایش رنگ اتنخاب شده </label>
                                    <div id="color_preview_2" style="border : 1px dashed #ccc ; background-color: #{{$manifest['theme_color']}} ; height:35px ; width: 100%;"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">

                            <label>توضیحات</label>
                            <textarea name="description" class="form-control"   rows="10" maxlength="190">{{($manifest['description'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label>رنگ متن</label>
                                <input name="text_color" class="form-control tal" style='direction: ltr' onkeyup="$('#color_preview_3').css('background-color' , '#' + this.value)" placeholder="e933ef" value="{{($manifest['text_color'])}}">

                            </div>
                            <div class="col-md-6">
                                <label> پیشنمایش رنگ اتنخاب شده </label>
                                <div id="color_preview_3" style="border : 1px dashed #ccc ; background-color: #{{$manifest['text_color']}} ; height:35px ; width: 100%;"></div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <span>پیش نمایش ایکون برنامه</span>
                                <br>
                                @if ($manifest['icon'])
                                    <img id="blah" style="width: 120px;height: 120px ; margin: 10px;" src="/local/uploads/manifest/icon/512/{{$manifest['icon']}}" alt='آیکون'>
                                @else
                                    <span class="red">ایکونی ثبت نشده است</span>
                                @endif
                            </div>
                        </div>

                    </div>


                        <button type="submit" class="btn btn-block btn-primary" > ثبت </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
