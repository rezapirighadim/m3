@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedCategories) && $requestedCategories !== null) {
        $ready = true;
        $requestedData = $requestedCategories;
    }
    ?>

    <script>
        $(document).ready(function() {
            document.getElementById("uploadBtn").onchange = function () {
                document.getElementById("uploadFile").value = this.value;
            };

            $("#uploadBtn").change(function () {
                readURL(this);
            });
        });
    </script>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم اضافه کردن بنر</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/banners') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">
                        {{--<div class="col-md-12">--}}
                            <p class="alert alert-warning">در صورتی که میخواهید با زدن روی بنر در گوشی ٬ صفحه سایتی را باز کنید قسمت لینک را پر کنید .</p>
                        {{--</div>--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عنوان بنر</label>
                                    <input name="title" class="form-control" value="<?=($ready ? $requestedData['title'] : "")?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>لینک</label>
                                    <input name="link" class="form-control" value="<?=($ready ? $requestedData['link'] : "")?>" >
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
                                        <img src="/uploads/banners/{{$requestedData['image']}}" alt="" width="100%" >
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>توضیحات</label>
                                    <textarea rows="5" name="description" class="form-control" ><?=($ready ? $requestedData['description'] : "")?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p style="margin-top: 10px;margin-right: 15px;">موقیت بنر</p>

                                <div class="col-md-3">
                                    <label class="radio">
                                        <input class="icheck-red" type="radio" name="position"
                                               {{!$ready ? 'checked' : ''}}
                                               {{$ready && $requestedData['position'] == 'top' ? 'checked' : ''}}
                                               id="radioRedCheckbox1" value="top" >  تصویر ثابت بالا
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="radio">
                                        <input class="icheck-blue" type="radio" name="position"
                                               {{$ready && $requestedData['position'] == 'center' ? 'checked' : ''}}
                                               id="radioRedCheckbox2" value="center"> تصویر ثابت میانی
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="radio">
                                        <input class="icheck-black" type="radio" name="position"
                                               {{$ready && $requestedData['position'] == 'bottom' ? 'checked' : ''}}
                                               id="radioRedCheckbox5" value="bottom"> تصویر ثابت پایین
                                    </label>
                                </div>
                            </div>

                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ایجاد بنر " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">بنر های ثبت شده </h3>
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
                                        <th>بنر</th>
                                        <th>عنوان</th>
                                        <th>لینک</th>
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
                                        <td><img style="width: 80px ; height: 80px; border-radius: 50%" src="{{URL::to('/uploads/banners/' . $record['image'])}}" alt=""></td>
                                        <td class=""><?=$record['title'];?></td>
                                        <td><?=$record['link'];?></td>

                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/banners/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
                $.ajax("/admin/remove_banner/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {

                        parent.remove();
                        Swal.fire({"title":"بنر با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    }
                });
            }
        }
        function note_edit() {

        }
    </script>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    </script>
@endsection
