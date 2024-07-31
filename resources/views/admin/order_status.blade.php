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
                    <h3 class="panel-title">فرم ایجاد وضعیت سفارش</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/status') }}" method="post" enctype="multipart/form-data">
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
                                    <label>عنوان وضعیت سفارش</label>
                                    <input name="title"  class="form-control" value="<?=($ready ? $reqCat['title'] : "")?>" placeholder="عنوان وضعیت سفارش را وارد کنید">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ترتیب</label>
                                    <input name="order" type="number"  class="form-control number" value="<?=($ready ? $reqCat['order'] : "")?>" placeholder="اعداد صحیح از صفر تا 127">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-6" >
                                <label class="checkbox">
                                    <input   <?=($ready && $reqCat['active'] == '1' ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="active"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> فعال </span>
                                </label>
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
                    <h3 class="panel-title">لیست وضعیت های سفارش </h3>
                </div>
                <div class="panel-body">
                    <section class="row component-section">

                        <!-- responsive table title and description -->

                        <!-- responsive table code and example -->
                        <div class="col-md-12">
                            <!-- responsive table example -->
                            <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                <table class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عنوان</th>
                                        <th>فعال</th>
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
                                        <td><?=($record['active'] == '1' ? "فعال" : "غیر فعال")?></td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/status/<?=$record['id'];?>" ><span  class="label label-default">ویرایش</span></a>

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

        $(document).ready(function() {

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
