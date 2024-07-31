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
                    <h3 class="panel-title">فرم اضافه کردن ناشران</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/publishers') }}" method="post" enctype="multipart/form-data">
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
                                    <label>عنوان ناشر</label>
                                    <input name="title" class="form-control" value="<?=($ready ? $reqCat['title'] : "")?>" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نام مدیر</label>
                                    <input name="manager" class="form-control" value="<?=($ready ? $reqCat['manager'] : "")?>" >
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

                            </div>

                             <div class="col-md-6">
                                <div style="margin-top: 17px">
                                    <div class="fileUpload btn btn-info">
                                        <span>انتخاب تصویر محصول</span>
                                        <input id="uploadBtn" type="file" name="image" class="upload"  accept="image/jpeg, image/png"/>
                                    </div>
                                    <input class="form-control" id="uploadFile" type="text" placeholder="نام عکس انتخاب شده" disabled>

                                </div>
                             </div>



                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>آدرس</label>
                                    <textarea rows="5" name="address" class="form-control" ><?=($ready ? $reqCat['address'] : "")?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>توضیحات</label>
                                    <textarea rows="5" name="description" class="form-control" ><?=($ready ? $reqCat['description'] : "")?></textarea>
                                </div>
                            </div>
                            @if ($ready && $reqCat['icon'])
                                <div class="col-md-6">
                                    <img style="max-height: 200px" src="{{URL::to('/local/uploads/publishers/' . $reqCat['icon'])}}" alt="آیکون ناشر">
                                </div>
                            @endif

                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت ناشر " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">پدیدآورنده های ثبت شده </h3>
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
                                        {{--<th>نام پدیدآورنده</th>--}}
                                        <th>نوع</th>
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

                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/publishers/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>
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
