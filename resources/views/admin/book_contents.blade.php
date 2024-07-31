@extends('admin.theme.main')
@section('content')

    <?
    $ready = false;
    if (isset($reqBookContent) && $reqBookContent !== null) {
//        dd($requestedBook);
        $ready = true;
        $reqBook = $reqBookContent;
    }
    ?>

    <script>
        function close_window() {
            if (confirm("آیا مطمعن هستید ؟‌")) {
                close();
            }
        }
        function remove_content(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_book_contents/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log('success');
                        console.log(data);
                        parent.remove();
                        Swal.fire({"title":"محتوا با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    },
                    error: function (data) {
                        console.log('error');
                        console.log(data);
                    }
                });
            }
        }





        $(document).ready(function() {

            CKEDITOR.replace( 'book_content_editor' );
            CKEDITOR.config.height = 400;

            document.getElementById("uploadBtn").onchange = function () {
                document.getElementById("uploadFile").value = this.value;
            };

            $('input[type=radio][name=input_type]').on('ifChecked', function(event){
                var value = this.value;
                if(value == 'upload'){
                    $("#content_upload").css('display' , 'block');
                    $("#content_text").css('display' , 'none');
                }else{
                    $("#content_upload").css('display' , 'none');
                    $("#content_text").css('display' , 'block');
                }

            });




            var cash = $(".number");

            $(cash).keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl/cmd+A
                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+C
                    (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+X
                    (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

        });

    </script>
    <?if(isset($AffectedRows) && $AffectedRows){?>

    <div class="alert alert-success" style="margin-bottom: 0px !important;">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        محصول شما با موفقیت ارسال شد .
    </div>

    <?}?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span style="color: #bcbcbc">مشخصات کتاب  <span class="red">:</span> </span> <span style="line-height: 1.5em ; ">{{ $book_info['title'] }}</span></h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                    <p class="hoverP2"> <span class="info-label-2"> قیمت نمایشی فیزیکی :</span> <span class="info-body-2">{{ $book_info['show_price'] ? $book_info['show_price'] . ' تومان ' : 'وارد نشده'}}  </span> </p>
                    <p class="hoverP2"> <span class="info-label-2">قیمت فروش فیزیکی :</span> <span class="info-body-2">{{ $book_info['price'] ? $book_info['price'] . ' تومان ' : 'وارد نشده'}} </span> </p>
                    </div>
                    <div class="col-md-6">
                        <p class="hoverP2"> <span class="info-label-2"> قیمت نمایشی دانلودی :</span> <span class="info-body-2">{{ $book_info['show_price_in_app'] ? $book_info['show_price_in_app'] . ' تومان ' : 'وارد نشده'}}  </span> </p>
                        <p class="hoverP2"> <span class="info-label-2">قیمت فروش دانلودی :</span> <span class="info-body-2">{{ $book_info['price_in_app'] ? $book_info['price_in_app'] . ' تومان ' : 'وارد نشده'}} </span> </p>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div>
                            <a href="/admin/books/{{$book_id}}" class="btn btn-sm btn-primary" >ویرایش</a>

                            <span onclick="close_window();return false;" class="btn btn-sm btn-danger " >بستن این صفحه</span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ثبت محتوای کتاب در </h3>
                </div>
                <div class="panel-body">
                    <form class="ls_form" role="form" action="{{ URL::to('admin/book_contents') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $content_id : "0")?>">
                        <input type="hidden" name="book_id"  value="<?=$book_id?>">
                        <input type="hidden" name="book_contents"  value="<?=($ready ? $content_id : '')?>">

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



                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>عنوان فصل</label>
                                        <input name="title" class="form-control" value="<?=($ready ? $reqBook['title'] : "")?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ترتیب</label>
                                        <input name="order" placeholder="عدد لاتین وارد شود" class="form-control number" value="<?=($ready ? $reqBook['order'] : "0")?>" >
                                    </div>
                                </div>
                            </div>




                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-md-2">
                                    <p style="margin-top: 10px;">نوع ورودی اطلاعات : </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="radio">
                                        <input {{!$ready || $reqBook['content'] ? 'checked' : ''}} onchange="alert()" class="icheck-square-green" type="radio" name="input_type"
                                               data-value="text" value="text"> محتوای متنی
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="radio">
                                        <input {{$ready && !$reqBook['content'] ? 'checked' : ''}}  class="icheck-square-green" type="radio" name="input_type"
                                               data-value="upload" value="upload"> محتوای آپلودی
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>


                        <div id="content_upload"  class="desNone">
                            <div  class="col-md-12 ">
                                <p class="alert alert-info">فایل آپلودی باید  شامل index.html در داخل یک فایل زیپ  (ZIP) بدون رمز عبور باشد.</p>
                            </div>
                            <div class="col-md-7">
                                <div class="fileUpload btn btn-info">
                                    <span>انتخاب فایل زیپ</span>
                                    <input id="uploadBtn" type="file" name="file" class="upload"  accept=".zip,.ZIP"/>
                                    <input  type="hidden" name="lastFileName"  />
                                </div>
                                <input class="form-control" id="uploadFile" type="text" placeholder="فایل انتخاب شده" disabled>
                                <hr>

                            </div>
                        </div>

                        <div id="content_text" class="col-md-12">
                            <p style="background-color: #FAFAFA !important; border: none !important;">  محتوای مربوط به کتاب را وارد کنید </p>
                            <div class="panel-body no-padding">

                                <textarea name="content" id="book_content_editor" rows="90" ><?=($ready ? $reqBook['content'] : "")?></textarea>
                                {{--<textarea name="content"  class="bookContents" >  </textarea>--}}
                            </div>
                            <br>

                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-warning btn-block" style="height: 35px;"><?=($ready ? 'ویرایش و پیش نمایش کتاب' : ' ثبت کتاب ')?></button>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            @if ($ready && $content_id)
                                <a target="_blank" href="/admin/content_preview/{{$content_id}}" class="btn btn-primary btn-block">پیش نمایش نسخه قبل</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> محتوا (فهرست) های ثبت شده برای این کتاب </h3>
                </div>
                <div class="panel-body">
                    <section class="row component-section">

                        <!-- responsive table name and description -->

                        <!-- responsive table code and example -->
                        <div class="col-md-12">
                            <!-- responsive table example -->
                            <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>ترتیب</th>
                                        <th>عنوان</th>
                                        <th>نمایش کامل</th>
                                        <th>عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?
                                    if(isset($records) && $records != null){
                                    foreach($records as $record){?>
                                    <tr class="cat_row">
                                        <td><?=$record['id'];?></td>
                                        <td><?=$record['order'];?></td>
                                        <td><?=$record['title'];?></td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/book_contents/{{$book_id}}/{{$record['id']}}" ><span  class="label label-default">ویرایش</span></a>
                                            <a class=" label label-danger" onclick="remove_content(this , {{$record['id']}} )">حذف</a>

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


@endsection
