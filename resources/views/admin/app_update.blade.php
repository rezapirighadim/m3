@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedCategories) && $requestedCategories !== null) {
        $ready = true;
        $reqCat = $requestedCategories;
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
                    <h3 class="panel-title">فرم به روز رسانی</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/app_update') }}" method="post" enctype="multipart/form-data">
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
                                    <label>نام پکیج برنامه (package name)</label>
                                    <input name="pkg_name" placeholder="package name like : com.mayamey" class="form-control ltr mono_font" value="<?=($ready ? $reqCat['pkg_name'] : "")?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ورژن (version number)</label>
                                    <input name="version_no" class="form-control" value="<?=($ready ? $reqCat['version_no'] : "")?>" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>نماینده (درصورت وجود)</label>
                                <select id="select_user" name="seller_id" multiple  class="demo-default" placeholder="جستجو و انتخاب نماینده (فروشنده)">
                                    <?foreach ($sellers as $record){?>
                                    <option value="<?=$record['id']?>"><?=$record['name']?></option>
                                    <?}
                                    if($ready) {
                                        echo "<script> $(function(){ $('#select_user').val(" . $reqCat['seller_id'] ." ) ;}); </script>";
                                    }
                                    ?>
                                </select>

                                <div style="margin-top: 17px">
                                    <div class="fileUpload btn btn-info">
                                        <span>انتخاب فایل برنامه</span>
                                        <input id="uploadBtn" type="file" name="app_file" class="upload" />
                                    </div>
                                    <input class="form-control" id="uploadFile" type="text" placeholder="نام فایل انتخاب شده" disabled>

                                </div>
                            </div>

                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label>توضیحات</label>
                                     <textarea rows="5" name="description" class="form-control" ><?=($ready ? $reqCat['description'] : "")?></textarea>
                                 </div>

                             </div>



                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-6">

                                    <label class="checkbox">
                                        <input  <?=($ready && $reqCat['force_update'] == 'yes' ? "checked":"")?>   class="icheck-purple" name="force_update" type="checkbox" id="checkRed5" >
                                        <span>اجبار کاربر به دانلود</span>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت به روزرسانی " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">بروزرسانی های ثبت شده </h3>
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
                                        <th>ردیف</th>
                                        <th>نوع</th>
                                        <th>فروشنده</th>
                                        <th>ورژن</th>
                                        <th>فایل</th>
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
                                        <td class=""><?=$record['os'];?></td>
                                        <td class=""><?=$record['seller_id'];?></td>
                                        <td class=""><?=$record['version_no'];?></td>
                                        <td class=""><?=$record['app_file'];?></td>

                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/app_update/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
                $.ajax("/admin/remove_app_update/" + id, {
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
