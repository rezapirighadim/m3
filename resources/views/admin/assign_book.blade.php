@extends('admin.theme.main')
@section('content')

    <?
    $ready = false;
    if (isset($requestedBook) && $requestedBook !== null) {
//        dd($requestedBook);
        $ready = true;
        $reqBook = $requestedBook;
    }
    ?>


    <?if(isset($AffectedRows) && $AffectedRows){?>

    <div class="alert alert-success" style="margin-bottom: 0px !important;">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        محصول شما با موفقیت ارسال شد .
    </div>

    <?}?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ثبت کتاب در </h3>
                </div>
                <div class="panel-body">
                    <form class="ls_form" role="form" action="{{ URL::to('admin/assign_book') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <input type="hidden" name="book_id"  value="{{$requestedBook->id}}">
                        <input type="hidden" name="isbn"  value="{{$requestedBook->isbn}}">

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


                        </div>
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><span style="color: #bcbcbc">مشخصات کتاب  </span> <span style="line-height: 1.5em ; ">{{$ready ? $reqBook['title'] : ""}}</span></h3>
                                    </div>
                                    <div class="panel-body">
                                        <p class="hoverP2"> <span class="info-label-2"> تعداد صحفه :</span> <span class="info-body-2">{{$ready ? $reqBook['page_number'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">زبان کتاب :</span> <span class="info-body-2">{{$ready ? $reqBook['lang'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">محل نشر :</span> <span class="info-body-2">{{$ready ? $reqBook['publish_place'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">تاریخ نشر :</span> <span class="info-body-2">{{$ready && $reqBook['publish_date'] ? jdate('Y-m-d' , $reqBook['publish_date'] ) : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">کد دویی :</span> <span class="info-body-2">{{$ready ? $reqBook['dewey'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">شابک (ISBN) :</span> <span class="info-body-2">{{$ready ? $reqBook['isbn'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">بارکد کتاب :</span> <span class="info-body-2">{{$ready ? $reqBook['bar_code'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">قطع کتاب :</span> <span class="info-body-2">{{$ready ? $reqBook['cut'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">وزن کتاب (گرم) :</span> <span class="info-body-2">{{$ready ? $reqBook['weight'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">تعداد چاپ :</span> <span class="info-body-2">{{$ready ? $reqBook['print_count'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">تیراژ :</span> <span class="info-body-2">{{$ready ? $reqBook['circulation'] : ""}}</span> </p>
                                        <p class="hoverP2"> <span class="info-label-2">ناشر(ناشران) :</span> <span class="info-body-2">{{$ready ? $reqBook['publishers'] : ""}}</span> </p>
                                        <hr>
                                        @foreach($reqBook['creators'] as $creator)
                                            <p class="hoverP2"> <span class="info-label-2">{{$creator['type']}} : </span> <span class="info-body-2">{{$creator['name']}}</span> </p>
                                        @endforeach
                                    </div>
                                </div>



                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">تصویر و پیش نمایش کتاب</h3>
                                    </div>
                                    <div class="panel-body" style="text-align: center">
                                        <div style="margin-top:10px ; display: flex; flex-direction: row ; justify-content: space-between">
                                            @if ($reqBook['pdfName'] && check_var($reqBook['pdfName']))
                                                <p class="book_pdf_preview "><a target="_blank" href="/local/uploads/books/pdf/{{$reqBook['pdfName']}}">مشاهده پیش نمایش کتاب</a></p>
                                                <p id="book_none_pdf" class="hidden red">پیش نمایشی برای این کتاب وجود ندارد</p>
                                            @else
                                                <p class="red">پیش نمایشی برای این کتاب وجود ندارد</p>
                                            @endif
                                        </div>
                                        <hr>
                                        <input type="hidden" name="imageName" value="{{$reqBook['imageName']}}">

                                    <?if ($ready && $reqBook['imageName']){?>
                                        <img style="width: 70% !important;" id="blah" src="{{url('/')}}/local/uploads/books/images/<?=$reqBook['imageName']?>" alt="تصویر انتخاب شده" />
                                        <?}else{?>
                                        <img style="width: 70% !important;" id="blah" src="#" alt="تصویر محصول را انتخاب کنید" />
                                        <?}?>
                                    </div>


                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-dark">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">فرم تکمیل اطلاعات فروش</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>جستجو و انتخاب دسته  </label>
                                                    <select id="select_user" name="category_id" multiple  class="demo-default" placeholder="جستجو و انتخاب دسته بندی">
                                                        <?foreach ($categories as $record){?>
                                                        <option value="<?=$record['id']?>"><?=$record->getParentsNames()?></option>
                                                        <?}
                                                        if($ready) {
                                                            echo "<script> $(function(){ $('#select_user').val(" . $assigned_book['category_id'] ." ) ;}); </script>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>قیمت کتاب فیزیکی (قبل از تخفیف)</label>
                                                <input type="text" class="form-control number" name="show_price" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $assigned_book['show_price'] : "")?>" placeholder="عدد به ریال">

                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>شماره قفشه</label>
                                                <input type="text" class="form-control number" name="shelf_id"  onkeyup="format(this)"  value="<?=($ready ? $assigned_book['shelf_id'] : "")?>" >
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>قیمت نهایی کتاب فیزیکی (اصلی)</label>
                                                <input type="text" class="form-control number" name="price" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $assigned_book['price'] : "")?>" placeholder="عدد به ریال">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>تعداد کتب موجود در انبار</label>
                                                <input type="text" class="form-control number" name="count" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $assigned_book['count'] : "")?>" placeholder="عدد">
                                            </div>





                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="checkbox">
                                                    <input   <?=($ready && $assigned_book['saleable'] == 1 ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="saleable"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                                    <span> قابلیت فروش فیزیکی </span>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-sm btn-success btn-block" style="height: 35px;">ثبت اطلاعات </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <a href="/admin/books_list"  class="btn btn-sm btn-warning btn-block" style="height: 35px;padding-top: 8px">برگشت به لیست کتاب ها</a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        function format(input){
            return;

            var nStr = input.value + '';
            nStr = nStr.replace( /\,/g, "");
            var x = nStr.split( '.' );
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while ( rgx.test(x1) ) {
                x1 = x1.replace( rgx, '$1' + ',' + '$2' );
            }
            input.value = x1 + x2;
        }





        $(document).ready(function() {
            CKEDITOR.replace( 'book_content_editor' );
            CKEDITOR.config.height = 400;



            $('#title').bind('keyup change ', function(){
                var title = $(this).val();
                title = title.replace(/ /gi,'-');
                $('#url_title').val(title);
            });

            document.getElementById("uploadBtn").onchange = function () {
                document.getElementById("uploadFile").value = this.value;
            };

            $("#uploadBtn").change(function(){
//            alert("a");
                readURL(this);
            });

            document.getElementById("uploadPdfBtn").onchange = function () {
                document.getElementById("uploadPdfFile").value = this.value;
            };

//             $("#uploadPdfBtn").change(function(){
// //            alert("a");
//                 readURL(this);
//             });


            var cash = $(".number");

            $(cash).keydown(function (e) {
//            alert('aaa');
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

@endsection
