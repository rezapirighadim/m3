@extends('admin.theme.main')
@section('content')

<?
$ready = false;
if (isset($requestedReception) && $requestedReception!== null){
    $ready = true;
    $reqReception = $requestedReception ;
}
//dump($receptions);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">فرم ثبت تعرفه جدید</h3>
            </div>
            <div class="panel-body">
                <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                <?=(isset($error) ? "<p class=\"alert alert-danger\">$error</p>" : "")?>

                <form class="ls_form" role="form" action="{{ URL::to('admin/tariff') }}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="edit"  value="<?=($ready ? $reqReception['id'] : "0")?>">
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
                    <div class="col-lg-6 col-sm-12">

                        <div class="form-group">
                            <label>عنوان</label>
                            <input name="title" class="form-control" value="<?=($ready ? $reqReception['title']:"")?>" placeholder="عنوان را وارد کنید .">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تعداد روز</label>
                                    <input name="days" class="form-control" value="<?=($ready ? $reqReception['days']:"")?>" placeholder="فقط عدد">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تعداد کتاب قابل دسترس</label>
                                    <input  name="book_limit" class="form-control" value="<?=($ready ? $reqReception['book_limit']:"")?>" placeholder="عدد">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-sm-12">

                        <div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>قیمت بعد از تخفیف</label>
                                    <input  name="discounted_price" class="form-control" value="<?=($ready ? $reqReception['discounted_price']:"")?>" placeholder="به ریال وارد شود">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>قیمت بدون تخفیف</label>
                                    <input name="price" class="form-control" value="<?=($ready ? $reqReception['price']:"")?>" placeholder="به ریال وارد شود">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">

                            <div>
                                <div class="col-md-6">
                                    <label>رنگ</label>
                                    <input name="color" class="form-control tal" style='direction: ltr' onkeyup="$('#color_preview').css('background-color' , this.value)" placeholder="#e933ef" value="<?=($ready ? $reqReception['color']:"")?>">

                                </div>
                                <div class="col-md-6">
                                    <label> پیشنمایش رنگ اتنخاب شده </label>
                                    <div id="color_preview" style="border : 1px dashed #ccc ; background-color: {{$ready ? $reqReception['color']:""}} ; height:35px ; width: 100%;"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-12 col-sm-12">


                        <div class="form-group">

                            <label>توضیحات</label>
                            <textarea name="description" class="form-control"   rows="7"><?=($ready ? $reqReception['description']:"")?></textarea>
                        </div>

                    </div>


                        <button type="submit" class="btn btn-block <?=(!$ready ? "btn-primary" : "btn-success")?>"> <?=(!$ready ? "ثبت " : "ویرایش")?> </button>

                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">لیست تعرفه ها </h3>
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
                                    <th>شناسه</th>
                                    <th>عنوان</th>
                                    <th>قیمت قبل از تخفیف</th>
                                    <th>قیمت بعد تخقیف</th>
                                    <th class="tac">نمایش کامل</th>
                                    <th>عملیات</th>

                                </tr>
                                </thead>

                                <tbody>
                                <?
                                if(isset($tariffs) && $tariffs!=null){
                                foreach($tariffs as $tariff){?>
                                <tr class="cat_row">
                                    <td><?=$tariff['id'];?></td>
                                    <td><?=$tariff['title'];?></td>
                                    <td><?=($tariff['price']);?></td>
                                    <td><?=($tariff['discounted_price']);?></td>
                                    <td class="tac">مشاهده</td>
                                    <td>
                                        <a style="text-decoration: none;cursor: pointer"; href="/admin/tariff/<?=$tariff['id'];?>" ><span class="label label-default">ویرایش</span></a>
                                        <a style="text-decoration: none;cursor: pointer"; onclick="remove_tarrif(this , <?=$tariff['id']?> )"><span class="label label-danger" id="change_reception_activity">حذف</span></a>
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
    function change_activity(sender,id) {
        if (confirm("آیا مطمعن هستید؟")) {
            sender = $(sender);
            var parent = sender.children('#change_reception_activity').html();

            $.ajax("/admin/update_reception_activity/" + id, {
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if(parent == "غیر فعال سازی"){
                        sender.children('#change_reception_activity').html("فعال سازی");
                    }else{
                        sender.children('#change_reception_activity').html("غیر فعال سازی");
                    }
                    alert(data);
                }
            });
        }
    }
</script>
@endsection
