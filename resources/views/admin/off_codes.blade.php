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
                    <h3 class="panel-title">فرم ایجاد کد تخفیف</h3>
                </div>
                <div class="panel-body">
                    <p class="alert alert-info">در صورتی که میخواهید کد تخفیف فقط برای کاربر خاصی قابل استفاده باشد شماره موبایل کاربر را وارد کنید  در غیر این صورت کد تخفیف برای همه قابل استفاده خواهد بود. </p>
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/off_codes') }}" method="post" enctype="multipart/form-data">
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
                                            <label>عنوان کد تخفیف</label>
                                            <input name="title" class="form-control" value="<?=($ready ? $reqCat['title'] : "")?>" placeholder="عنوان کد تخفیف">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>اعتبار کد تخفیف تا تاریخ</label>
                                            <input name="expire_ts" id="observer1" aonkeydown="return false" class="form-control" value="<?=($ready ? $reqCat['expire_ts']  : "")?>" placeholder="اعتبار تا تاریخ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>کد تخفیف (لاتین)</label>
                                            <input name="code" class="form-control" value="<?=($ready ? $reqCat['code'] : "")?>" placeholder="کد">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>درصد تخفیف</label>
                                                    <input name="percent" class="form-control" value="<?=($ready ? $reqCat['percent'] : "")?>" placeholder="عدد">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>سقف تخفیف</label>
                                                    <input name="max_limit" class="form-control" value="<?=($ready ? $reqCat['max_limit'] : "")?>" placeholder="به ریال">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت کد تخفیف " : "ویرایش کد تخفیف")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">کدهای تخفیف ثبت شده </h3>
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
                                        <th>عنوان تخفیف</th>
                                        <th>کد</th>
                                        <th>درصد</th>
                                        <th>سقف</th>
                                        <th>تاریخ انقضا</th>
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
                                        <td class=""><?=$record['code'];?></td>
                                        <td class=""><?=$record['percent'];?>%</td>
                                        <td class=""><?=$record['max_limit'] ?? 'ندارد';?></td>
                                        <td class="">{{jdate('Y/m/d' , $record['expire_ts'])}}</td>
                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
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
                $.ajax("/admin/remove_off_codes/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
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
