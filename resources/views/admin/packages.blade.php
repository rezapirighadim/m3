@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedData) && $requestedData !== null) {
        $ready = true;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ایجاد پکیج </h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/package') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">

                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-info">برای ایجاد پکیج رایگان قیمت پکیج را صفر یا خالی قرار دهید. </p>
                                <p class="alert alert-warning">توجه داشته باشید عدد را با اعداد لاتین و به ریال وارد کنید .</p>
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
                                <div class="form-group">
                                    <label>عنوان پکیج</label>
                                    <input name="title" class="form-control" value="<?=($ready ? $requestedData['title'] : "")?>" placeholder="">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> جستجو و انتخاب دسته بندی  </label>
                                    <select id="select-state" name="categories[]" multiple  class="demo-default" placeholder="جستجو و انتخاب محتوا">
                                        @foreach ($categories as $record)
                                            <option value="{{$record['id']}}" {{$ready && in_array($record['id'] , $requestedData['categories'])  ? 'selected' : ''}}>{{$record['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>قیمت</label>
                                    <input  name="price" class="form-control" value="<?=($ready ? $requestedData['price'] : "")?>" placeholder="قیمت به ریال ">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6" style="margin-top: 15px;;">
                                    <div class="fileUpload btn btn-info">
                                        <span>انتخاب تصویر  پکیج</span>
                                        <input id="uploadBtn" type="file" name="image" class="upload" accept="image/jpeg, image/jpg,  image/bmp , image/png"/>
                                    </div>
                                    <input class="form-control" id="uploadFile" type="text" placeholder="نام فایل انتخاب شده" disabled>
                                    @if (isset($requestedData['image']) && $requestedData['image'])
                                        <img src="/uploads/packages/{{$requestedData['image']}}" alt="" width="100%" >
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <br><br>
                                    @if (isset($requestedData['image']) && $requestedData['image'])
                                        <p class="alert alert-info">با انتخاب عکس جدید عکس قبلی پاک شده و عکس جدید جایگزین میشود.</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <p style="background-color: #FAFAFA !important; border: none !important;">  توضیحات کامل مربوط به پکیج </p>
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <textarea name="description" id="book_content_editor"  ><?=($ready ? $requestedData['description'] : "")?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input   <?=($ready && $requestedData['available']  ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="available"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> قابلیت فروش </span>
                                </label>
                            </div>


                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت  " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">پکیج های ثبت شده </h3>
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
                                        <th>نام پکیج</th>
                                        <th>قیمت</th>
                                        <th>قابلیت فروش</th>
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
                                        <td class="">{{ $record['price'] }}</td>

                                        <td><?=($record['available'] == '1' ? "دارد" : "ندارد")?></td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/package/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
    <script>
        function cat_remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_package/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        parent.remove();
                        Swal.fire({"title":" با موفقیت حذف شد!","text":"","timer":"1500","width":"400","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    }
                });
            }
        }
    </script>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };

        $(document).ready(function() {
            CKEDITOR.replace( 'book_content_editor' );
            CKEDITOR.config.height = 400;

        });

    </script>
@endsection
