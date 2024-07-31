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
                <h3 class="panel-title">فرم ثبت نماینده (فروشنده) جدید</h3>
            </div>
            <div class="panel-body">
                <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                <?=(isset($error) ? "<p class=\"alert alert-danger\">$error</p>" : "")?>

                <form class="ls_form" role="form" action="{{ URL::to('admin/submit_seller') }}" method="post">
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
                            <label>نام و نام خانوادگی کارمند</label>
                            <input name="fullName" class="form-control" value="<?=($ready ? $reqReception['name']:"")?>" placeholder="نام و نام خانوادگی کارمند را وارد کنید .">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>شماره موبایل کارمند</label>
                                    <input name="phone" class="form-control" value="<?=($ready ? $reqReception['phone']:"")?>" placeholder="مثل : 09121234567">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>رمز ورود برای سیستم</label>

                                    <input name="password" class="form-control"  placeholder="<?=($ready ?  "درصورتی که میخواید پسورد کارمند همان پسورد قبلی باشد این فیلد را پر نکنید" :"رمز عبور کارمند")?>">
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6 col-sm-12">


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ایمیل کارمند</label>
                                    <input type="email" name="email" class="form-control" value="<?=($ready ? $reqReception['email']:"")?>" placeholder="ایمیل کارمند">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نام کاربری</label>
                                    <input name="username"   class="form-control" value="<?=($ready ? $reqReception['username']:"")?>" placeholder="نام کاربری">
                                    {{--{{$ready && isset($reqReception) && $reqReception['username'] ? 'disabled' :""}}--}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاریخ انقضا</label>
                                    <input name="expire_time" class="form-control" value="<?=($ready ? jdate('Y/m/d' , $reqReception['expire_time']) :"")?>" placeholder="مثل : 1399/01/01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>دسترسی به کتب</label>
                                    <input name="book_limit" class="form-control" value="<?=($ready ? $reqReception['book_limit']:"")?>" placeholder="عدد">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input   <?=($ready && $reqReception['active'] ? "checked":"")?> name="active"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> تایید شده ثبت شود </span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="checkbox">
                                    <input   <?=($ready && $reqReception['shop'] ? "checked":"")?> name="shop"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                                    <span> دسترسی به فروشگاه </span>
                                </label>
                            </div>
                        </div>
                        <hr>
                    </div>




                    <hr>

                    <p class="guild_p">
                        <span class="add_btn" onclick="add_creator(this)"> + </span>
                        اضافه کردن لینک مارکت های برنامه
                    </p>
                    <hr>

                    <div class="row col-md-12" id="book_creator">
                        @if ($ready && $reqReception['markets'])
                            @foreach($reqReception['markets'] as $key => $value)
                                <div class="markets">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control " name="markets[{{$key}}][title]" value="{{$value['title']}}" placeholder="نام مارکت" id="long">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control ltr" name="markets[{{$key}}][link]" value="{{$value['link']}}" placeholder="Link" id="long">
                                        </div>
                                    </div>
                                    <div class="col-md-2" >
                                        <span class="delete_btn" onclick="remove_creator(this)"> X </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>



                    <hr>

                        <button type="submit" class="btn btn-block <?=(!$ready ? "btn-primary" : "btn-success")?>"> <?=(!$ready ? "ثبت " : "ویرایش")?> </button>

                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">لیست فروشندگان </h3>
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
                                    <th>نام و نام خانوادگی</th>
                                    <th>نام کاربری</th>
                                    <th>ایمیل</th>
                                    <th>شماره موبایل</th>
                                    <th>hash</th>
                                    <th>مشاهده</th>
                                    <th>عملیات</th>

                                </tr>
                                </thead>

                                <tbody>
                                <?
                                if(isset($receptions) && $receptions!=null){
                                foreach($receptions as $reception){?>
                                <tr class="cat_row">
                                    <td><?=$reception['id'];?></td>
                                    <td><?=$reception['name'];?></td>
                                    <td><?=$reception['username'];?></td>
                                    <td><?=$reception['email'];?></td>
                                    <td><?=$reception['phone'];?></td>
                                    <td>
                                        <span id="seller_hash" onclick="copy_clip(this)" style="display : block !important; max-width: 300px; font-size: 13px;font-family:monospace ;height: 30px  ; overflow: scroll ; background-color: #777777;border-radius: 5px; color : #fff" ><?=$reception['hash'];?></span>
                                    </td>
                                    <td>مشاهده</td>
                                    <td>
                                        <a style="text-decoration: none;cursor: pointer"; href="/admin/submit_seller/<?=$reception['id'];?>" ><span  class="label label-default">ویرایش</span></a>
                                        <a style="text-decoration: none;cursor: pointer"; onclick="change_activity(this , <?=$reception['id']?> )"><span  class="label label-danger" id="change_reception_activity"><?=(strhas($reception['pass'], "//////") ? "فعال سازی" : "غیر فعال سازی")?></span></a>
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

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function add_creator() {
        var id = makeid(6);
        $("#book_creator").append("<div class='markets'>" +
            " <div class='col-md-5'>" +
            " <div class='form-group'>" +
            "<input type='text' class='form-control'  name='markets[" + id + "][title]' placeholder='نام مارکت'>" +
            " </div>" +
            " </div>" +
            "<div class='col-md-5'>" +
            "<div class='form-group'>" +
            "<input type='text' class='form-control ltr mono_font' name='markets[" + id + "][link]' placeholder='Link' >" +
            "</div>" +
            "</div>" +
            "<div class='col-md-2' ><span class='delete_btn' onclick='remove_creator(this)'> X </span></div>" +
            "</div>");

    }

    function remove_creator(element) {
        var sender = $(element);
        var parent = sender.parentsUntil('.markets').parent();
        parent.remove();
    }

    

    function copy_clip(element) {
        var range, selection, worked;

        if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();
            range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        try {
            var x = document.execCommand('copy');
            console.log(element.innerText);
            if (element.innerText){
                Swal.fire({"title":"کپی شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});
            }

        }
        catch (err) {
            console.log('خطا! متن کپی نشد.');
            // alert('خطا! متن کپی نشد.');
        }
    }
</script>
@endsection
