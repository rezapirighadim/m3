@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedCategories) && $requestedCategories !== null) {
        $ready = true;
        $requestedData = $requestedCategories;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ایجاد دسته بندی</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/categories') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>عنوان دسته بندی</label>
                                    <input name="title" class="form-control" value="<?=($ready ? $requestedData['title'] : "")?>" placeholder="نام دسته بندی مورد نظر را برای ایجاد وارد کنید .">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>قیمت (ریال)</label>
                                    <input name="price" class="form-control" value="<?=($ready ? $requestedData['price'] : "")?>" placeholder="قیمت به ریال">
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
                                        <img src="/uploads/categories/{{$requestedData['image']}}" alt="" width="100%" >
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
                                <div class="form-group" >
                                    <label>توضیحات</label>
                                    <textarea name="description" class="form-control" id="book_content_editor"  placeholder="در صورت نیاز توضحیات مختصری را اینجا وارد کنید "><?=($ready ? $requestedData['description'] : "")?></textarea>

                                </div>
                            </div>



                            </div>




                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت دسته بندی " : "ویرایش")?> </button>
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
                                        <th>نام دسته بندی</th>
                                        <th>توضیحات</th>
                                        <th>تصویر</th>
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
                                        <td class="">
                                            <?
                                                if ($record['description'] != '' ){?>
                                                <a  class="popoverBox label label-light-green" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$record['description']?>">مشاهده توضیحات</a>
                                            <?}else{?>
                                                    <span  class="label label-dark">فاقد توضیحات</span>
                                                <?}?>
                                        </td>
                                        <td>
                                            <?if($record['image']!=''){?>
                                                <a href="<?=url('/')?>/uploads/categories/<?=$record['image']?>" target="_blank">نمایش</a>
                                            <?}else{?>
                                                <span  class="label label-dark">فاقد تصویر</span>
                                            <?}?>

                                        </td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/categories/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
        function note_edit() {

        }
    </script>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    </script>
@endsection
