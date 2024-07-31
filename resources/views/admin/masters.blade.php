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
                    <h3 class="panel-title">فرم ایجاد استاد</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/masters') }}" method="post" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <label>نام و نام  خانوادگی استاد</label>
                                    <input name="name" class="form-control" value="<?=($ready ? $reqCat['name'] : "")?>" placeholder="نام استاد را وارد فرمایید.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاریخ  تولد استاد</label>
                                    <input name="birthday" class="form-control" value="<?=($ready ? $reqCat['birthday'] : "")?>" placeholder="اختیاری ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاریخ  وفات استاد</label>
                                    <input name="death_day" class="form-control" value="<?=($ready ? $reqCat['death_day'] : "")?>" placeholder="اختیاری ">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 15px;;">
                                <div class="fileUpload btn btn-info">
                                    <span>انتخاب تصویر استاد</span>
                                    <input id="uploadBtn" type="file" name="image" class="upload" accept="image/jpeg, image/png"/>
                                </div>
                                <input class="form-control" id="uploadFile" type="text" placeholder="نام فایل انتخاب شده" disabled>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label>توضیحات</label>
                                    <textarea  name="description" rows="10" class="form-control" placeholder="در صورت نیاز توضحیات را اینجا وارد کنید "><?=($ready ? $reqCat['description'] : "")?></textarea>
                                </div>
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
                    <h3 class="panel-title">اساتید  ثبت شده </h3>
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
                                        <th>نام استاد</th>
                                        <th>تاریخ تولد</th>
                                        <th>تاریخ وفات</th>
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
                                        <td class="">{{ $record['name'] }}</td>
                                        <td class="">{{ $record['birthday'] }}</td>
                                        <td class="">{{ $record['death_day'] }}</td>

                                        <td class="">
                                            <?
                                                if ($record['description'] != '' ){?>
                                                <a  class="popoverBox label label-light-green" data-container="body" data-toggle="popover" data-placement="top" data-content="<?=$record['description']?>">مشاهده توضیحات</a>
                                            <?}else{?>
                                                    <span  class="label label-dark">فاقد توضیحات</span>
                                                <?}?>
                                        </td>
                                        <td>
                                            <?if($record['picture']!=''){?>
                                                <a href="<?=url('/')?>/uploads/masters/<?=$record['picture']?>" target="_blank">نمایش</a>
                                            <?}else{?>
                                                <span  class="label label-dark">فاقد تصویر</span>
                                            <?}?>

                                        </td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/masters/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
                $.ajax("/admin/remove_master/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        parent.remove();
                        Swal.fire({"title":"دسته بندی با موفقیت حذف شد!","text":"","timer":"1500","width":"400","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    },
                    error: function (data) {
                        console.log(data);
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
