@extends('admin.theme.main')
@section('content')


    <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">اطلاعات کاربران</h3>
            </div>
            <div class="panel-body">

                <?
                if(isset($requested_user)){
                    if($requested_user == null ){?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        کاربر مورد نظر یافت نشد !
                    </div>
                    <?}else{
                    $user = $requested_user;
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12">

                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title">اطلاعات کاربر</h3>
                            </div>
                            <div class="panel-body">
                                <p class="hoverP"> <span class="info-label"> شناسه کاربری :</span> <span class="info-body"> <?=$user['id']?></span> </p>
                                <p class="hoverP"> <span class="info-label">نام  :</span> <span class="info-body"><?=(check_var($user['name'])? $user['name'] : "وارد نشده" )?></span> </p>
                                <p class="hoverP"> <span class="info-label"> نام خانوادگی :</span> <span class="info-body"><?=(check_var($user['family'])? $user['family'] : "وارد نشده" )?></span> </p>
                                <p class="hoverP"> <span class="info-label">شماره موبایل :</span> <span class="info-body"><?=(check_var($user['phone'])? $user['phone'] : "وارد نشده" )?></span> </p>
                                <p class="hoverP"> <span class="info-label">تاریخ ثبت نام :</span> <span class="info-body"><?=piry_gregorian_to_jalali($user['created_at']);?></span> </p>
                                <p class="hoverP"> <span class="info-label">ایمیل :</span> <span class="info-body"><?=(check_var($user['email'])? $user['email'] : "وارد نشده" )?></span> </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                    </div>
                    <br>
                    <div class="col-md-12">

                    </div>
                <?}}?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".tooltipLink").tooltip({
            animation: true
        });
        $(".popoverBox").popover({
            animation: true
        });
    });

    function cat_remove(sender, id) {
        if (confirm("آیا مطمعن هستید؟")) {
            sender = $(sender);
            var parent = sender.parentsUntil('.cat_row').parent();
            $.ajax("/admin/remove_guild/" + id, {
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    parent.remove();
                }
            });
        }
    }
</script>
@endsection
