@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedData) && $requestedData !== null) {
        $ready = true;
        if (!$files) $files = [] ;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ایجاد محتوا</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form id="content_form" class="ls_form" role="form" action="{{ URL::to('admin/content') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" id="edit" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">

                        <div class="row">
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>نام محتوا</label>
                                            <input id="title" type="text" name="title"  value="<?=($ready ? $requestedData['title'] : "")?>" class="form-control" placeholder="عنوان محصول خود را وارد کنید .">
                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                        <label>جستجو و انتخاب دسته بندی  </label>
                                        <select id="select_user" name="category_id"   class="demo-default" placeholder="جستجو و انتخاب دسته بندی">
                                            <option >انتخاب کنید</option>

                                        @foreach ($categories as $record)
                                                <option value="{{$record['id']}}" {{$ready && $requestedData['category_id'] == $record['id'] ? 'selected' : ''}}>{{$record['title']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4" >
                                        <label>جستجو و انتخاب استاد  </label>
                                        <select id="select_user_1" name="master_id"   class="demo-default" placeholder="جستجو و انتخاب استاد">
                                            <option >انتخاب کنید</option>

                                            @foreach ($masters as $record)
                                                <option value="{{$record['id']}}" {{$ready && $requestedData['master_id'] == $record['id'] ? 'selected' : ''}}>{{$record['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <p style="background-color: #FAFAFA !important; border: none !important;">  توضیحات کامل مربوط به محتوا </p>
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <textarea name="description" id="book_content_editor"  ><?=($ready ? $requestedData['description'] : "")?></textarea>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">بارگذاری فایل و تصویر </h3>
                                    </div>
                                    <div class="panel-body" style="width: 100% ; height: 100%">

                                        @if (!$ready)
                                            <div class="col-md-12">
                                                <br>
                                                <p class="alert alert-info"> امکان آپلود بعد از ذخیره فعال خواهد شد.  </p>
                                            </div>
                                        @endif
                                        @if ($ready)
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="panel panel-dark">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">بارگذاری ویدیو </h3>
                                                        </div>
                                                        <div class="panel-body" style="width: 100% ; height: 100%">
                                                            @if (!isset($files['videoLink']) || !$files['videoLink'])
                                                                <div id="video_div" class="form-group col-md-12">
                                                                    <div class="col-md-12 ls-group-input">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div id="upload-container" >
                                                                                    <a id="browseFile" class="btn btn-primary">انتخاب ویدیو</a>
                                                                                    <a style="display: none" id="upload_video" class="btn btn-info">آپلود</a>
                                                                                </div>
                                                                                <br>
                                                                                <div  style="display: none;" class="progress " style="height: 10px">
                                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: 1%; height: 20px">1%</div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-footer p-4" style="display: none">
                                                                                <video id="videoPreview" src="" controls style="width: 100%; height: auto"></video>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <a href="/admin/remove_file/{{$files['videoId']}}" onclick="return confirm('آیا از حذف این ویدیو مطمعن هستید؟')" class="btn btn-danger">حذف ویدیو</a><br>
                                                                <div class="card-footer p-4">
                                                                    <video  src="{{$files['videoLink']}}" controls style="width: 100%; height: auto"></video>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="panel panel-dark">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">بارگذاری تصاویر </h3>
                                                        </div>
                                                        <div class="panel-body" style="width: 100% ; height: 100%">
                                                            <div  id="image_div" class="form-group col-md-12">
                                                                <div class="col-md-12 ls-group-input">
                                                                    <input name="content_images[]" id="content_images" type="file" multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="panel panel-dark">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">بارگذاری صوت  </h3>
                                                        </div>
                                                        <div class="panel-body" style="width: 100% ; height: 100%">
                                                            <div style="display: block" id="music_div" class="form-group col-md-12">
                                                                <div class="col-md-12 ls-group-input">
                                                                    <input name="content_musics[]" id="content_music" type="file" multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input   <?=($ready && $requestedData['visible'] == 'yes' ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="visible"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> نمایش داده شود </span>
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input   <?=($ready && $requestedData['free'] == 'yes' ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="free"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> محتوای رایگان </span>
                                </label>
                            </div>


                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">دسته بندی های ثبت شده </h3>
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
                                        <th>ردیف</th>
                                        <th>نام</th>
                                        <th>قابلیت نمایش</th>
                                        <th>رایگان</th>
                                        <th class="tac">نمایش کامل</th>
                                        <th>عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?
                                    if(isset($records) && $records != null){
                                    foreach($records as $record){?>
                                    <tr class="cat_row">
                                        <td><?=$record['id'];?></td>
                                        <td class="">{{ $record['title'] }}</td>
                                        <td><?=($record['visible'] == '1' ? "قابل مشاهده" : "غیر قابل مشاهده")?></td>
                                        <td><?=($record['free'] == '1' ? 'بله' : "خیر")?></td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/content/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
                                            <a class=" label label-danger" onclick="cat_remove(this , <?=$record['id'];?> )">حذف</a>

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

        </div>
    </div>

    <script type="text/javascript">

    </script>

    <script>
        function cat_remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_category/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        parent.remove();
                        Swal.fire({"title":"دسته بندی با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    }
                });
            }
        }

        $(document).ready(function() {
            document.getElementById('content_form').reset();
            CKEDITOR.replace( 'book_content_editor' );
            CKEDITOR.config.height = 400;

            var content_id = $("#edit").val();
            $('#content_type').on('change', function() {
                switch (this.value) {
                    case "image":
                        $('#content_music').fileinput('clear');
                        $('#content_video').fileinput('clear');

                        $("#image_div").css('display' , 'block');
                        $("#music_div").css('display' , 'none');
                        $("#video_div").css('display' , 'none');
                        break;
                    case "music":
                        $('#content_images').fileinput('clear');
                        $('#content_video').fileinput('clear');

                        $("#image_div").css('display' , 'none');
                        $("#music_div").css('display' , 'block');
                        $("#video_div").css('display' , 'none');
                        break;
                    case "video":
                        $('#content_images').fileinput('clear');
                        $('#content_music').fileinput('clear');

                        $("#image_div").css('display' , 'none');
                        $("#music_div").css('display' , 'none');
                        $("#video_div").css('display' , 'block');
                        break;
                    default :
                        $('#content_images').fileinput('clear');
                        $('#content_music').fileinput('clear');
                        $('#content_video').fileinput('clear');

                        $("#image_div").css('display' , 'none');
                        $("#music_div").css('display' , 'none');
                        $("#video_div").css('display' , 'none');
                        break;
                }
            });

                var imagePreview = [];
                var imagePreviewConfig = [];
                var musicPreview = [];
                var musicPreviewConfig = [];
                @if($ready)
                    var imagePreview = <?= isset($files['imagePreview']) ? json_encode($files['imagePreview'] , true) : json_encode([])?>;
                    var imagePreviewConfig = <?= isset($files['imagePreviewConfig']) ? json_encode($files['imagePreviewConfig'] , true) : json_encode([])?>;
                    var musicPreview = <?= isset($files['musicPreview']) ? json_encode($files['musicPreview'] , true) : json_encode([])?>;
                    var musicPreviewConfig = <?= isset($files['musicPreviewConfig']) ? json_encode($files['musicPreviewConfig'] , true) : json_encode([])?>;
                @endif


                $("#content_images").fileinput({
                uploadUrl : "/admin/upload_files/image/" +  content_id,
                deleteUrl: "/admin/delete_content_file/image/" + content_id,
                // browseOnZoneClick: true,
                showCaption: false,
                browseClass: "btn btn-ls",
                maxFileCount: 70,
                showUpload: true,
                uploadLabel :  'آپلود' ,
                browseLabel :  'انتخاب تصویر' ,
                removeLabel :  'حذف' ,
                dropZoneTitle : 'تصویر یا تصاویر را کشیده و اینجا رها کنید ... ' ,
                showDrag : false,
                overwriteInitial: true,
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreview: imagePreview ,
                initialPreviewConfig: imagePreviewConfig,
                allowedFileExtensions: ["jpg"  , 'jpeg', "png", "gif" , "psd" , "tiff" ],
                theme: 'fas',
                uploadExtraData:{ _token:'{{ csrf_token() }}' }

            });


            $("#content_music").fileinput({
                uploadUrl : "/admin/upload_files/music/" + content_id,
                deleteUrl: "/admin/delete_content_file/music/" + content_id,
                // browseOnZoneClick: true,
                showCaption: false,
                browseClass: "btn btn-ls",
                maxFileCount: 70,
                showUpload: true,
                uploadLabel :  'آپلود' ,
                browseLabel :  'انتخاب صوت' ,
                removeLabel :  'حذف' ,
                dropZoneTitle : 'صوت یا صوت ها را کشیده و اینجا رها کنید ... ' ,
                showDrag : false,
                overwriteInitial: true,
                initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
                initialPreview: musicPreview ,
                initialPreviewConfig: musicPreviewConfig,
                allowedFileExtensions: ["mp3"  , 'm4a'],
                theme: 'fas',
                uploadExtraData:{ _token:'{{ csrf_token() }}' }


            });




            $("#content_images").on("filepredelete", function(jqXHR) {
                var abort = true;
                if (confirm("آیا از حذف این تصویر مطمعن هستید ؟")) {
                    abort = false;
                }
                return abort;
            });

            $("#content_music").on("filepredelete", function(jqXHR) {
                var abort = true;
                if (confirm("آیا از حذف صوت  مطمعن هستید ؟")) {
                    abort = false;
                }
                return abort;
            });

            $('#content_images').on('fileuploaderror', function(event, data, msg) {
                console.log('Image uploaded', data.previewId, data.index, data.fileId, msg);
            });
            $('#content_music').on('fileuploaderror', function(event, data, msg) {
                console.log('music uploaded', data.previewId, data.index, data.fileId, msg);
            });
            $('#content_video').on('fileuploaderror', function(event, data, msg) {
                console.log('video uploaded', data.previewId, data.index, data.fileId, msg);
            });


            let browseFile = $('#browseFile');
            let resumable = new Resumable({
                target: '/admin/upload_large_file/' + content_id,
                query:{_token:'{{ csrf_token() }}'} ,// CSRF token
                fileType: ['mp4' , 'mkv' , 'mov' , 'mpeg' ],
                chunkSize: 1*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
                headers: {
                    'Accept' : 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 2,
            });

            $("#upload_video").on('click' , function () {
                showProgress();
                resumable.upload()
            });
            function upload_video(){
                showProgress();
                resumable.upload()
            }

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function (file) { // trigger when file picked
                $("#upload_video").show();
            });
            resumable.on('filesAdded', function (file) { // trigger when file picked
                console.log(file);
                // showProgress();
                // resumable.upload() // to actually start uploading.
            });

            resumable.on('fileProgress', function (file) { // trigger when file progress update
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
                response = JSON.parse(response);
                $('#videoPreview').attr('src', response.path);
                $('.card-footer').show();
                $("#upload_video").hide();
            });

            resumable.on('fileError', function (file, response) { // trigger when there is any error
                console.log(file);
                console.log(response);
                alert('file uploading error.');
                $("#upload_video").hide();
            });

            let progress = $('.progress');
            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`)
                progress.find('.progress-bar').html(`${value}%`)
            }

            function hideProgress() {
                progress.hide();
            }


            });
    </script>

@endsection
