@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedCategories) && $requestedCategories !== null) {
        $ready = true;
        $reqCat = $requestedCategories;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ایجاد خبر</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/news') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $reqCat['id'] : "0")?>">

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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>عنوان خبر</label>
                                            <input name="title" class="form-control" value="<?=($ready ? $reqCat['title'] : "")?>" placeholder="عنوان خبر">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>نمایش خبر تا تاریخ</label>
                                                    <input name="show_until" id="observer1" aonkeydown="return false" class="form-control" value="<?=($ready ?  $reqCat['show_until'] : "")?>" placeholder="نمایش تا تاریخ">
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="margin-top: 22px">
                                                <label class="checkbox">
                                                    <input   <?=($ready && $reqCat['is_active'] == '1' ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="is_active"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                                    <span>فعال </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 17px;">
                                <div class="fileUpload btn btn-info" >
                                    <span>انتخاب تصویر محصول</span>
                                    <input id="uploadBtn" type="file" name="image" class="upload" accept="image/jpeg, image/png"/>
                                </div>
                                <input class="form-control" id="uploadFile" type="text" placeholder="نام فایل انتخاب شده" disabled>
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>متن خبر</label>
                                    <textarea name="description" id="book_content_editor"  placeholder="متن خبر خود را اینجا وارد کنید." rows="90" ><?=($ready ? $reqCat['description'] : "")?></textarea>

                                </div>
                            </div>


                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت خبر " : "ویرایش خبر")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">خبر های ثبت شده </h3>
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
                                        <th>عنوان خبر</th>
                                        <th>متن</th>
                                        <th>تصویر</th>
                                        <th>وضعیت</th>
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
                                        <td class=""><?=$record['title'];?></td>

                                        <td class="">
                                            <?
                                                if ($record['body'] != '' ){?>
                                                <a  class="popoverBox label label-light-green" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$sendedSms['description']?>">مشاهده توضیحات</a>
                                            <?}else{?>
                                                    <span  class="label label-dark">فاقد توضیحات</span>
                                                <?}?>
                                        </td>
                                        <td>
                                            <?if($record['image']!=''){?>
                                                <a href="<?=url('/')?>/local/uploads/news/<?=$record['image']?>" target="_blank">نمایش</a>
                                            <?}else{?>
                                                <span  class="label label-dark">فاقد تصویر</span>
                                            <?}?>

                                        </td>
                                        <td><?=($record['show_until'] > time() && $record['is_active'] == 1 ? "قابل مشاهده" : "غیر قابل مشاهده")?></td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/news/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
        $(document).ready(function () {

            CKEDITOR.replace( 'book_content_editor' );
            CKEDITOR.config.height = 400;

            $("#observer1").persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue : false,
                observer: false,

            });

        });


        function cat_remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_news/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log('reza reza')
                        console.log(data)

                        parent.remove();
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
