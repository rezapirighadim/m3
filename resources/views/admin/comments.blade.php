@extends("admin.theme.main")
@section('content')

    <div class="row" style="margin-bottom: 20px">
        <div class="col-md-12 btn-group" role="group" aria-label="Basic example">
            <a href="/admin/comments" type="button" class="btn btn-primary">همه نظرات</a>
            <a href="/admin/comments/confirmed" type="button" class="btn btn-success">نظرات تایید شده</a>
            <a href="/admin/comments/not_confirmed" type="button" class="btn btn-danger">نظرات تایید نشده</a>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">کامنت های کاربران</h3>
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
                                <th class="tac">عنوان کتاب</th>
                                <th class="tac">متن</th>
                                <th class="tac">ثبت کننده</th>
                                <th class="tac">نمایش کامل</th>
                                <th class="tac">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($comments) && $comments!=null){
                            foreach($comments as $comment){?>
                            <tr class="cat_row">
                                <td><?=$comment['id'];?></td>
                                <td class="tac"><?
                                $string = \App\Models\Content::where('id' , $comment['content_id'])->pluck('title')->first();
                                echo mb_strlen($string)> 20 ? mb_substr($string , 0 , 20) . ' ... ' : $string;
                                ?></td>
                                <td class="tac"><?=$comment['body'];?></td>
                                <td class="tac"><a href="#/admin/user_info/<?=$comment['user_id']?>">{{$comment['user_name']}}</a></td>
                                <td class="tac">مشاهده</td>
                                <td class="tac">
                                    <a class=" label label-danger" onclick="cat_remove(this , <?=$comment['id']?> )">حذف</a>
                                    @if ($comment['confirm'] == 0)
                                        <a class=" label label-warning" onclick="confirm_comment(this , <?=$comment['id']?> )">تایید</a>
                                    @endif
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
    <script>
        function cat_remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_comment/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if (data) {
                            parent.remove();
                            Swal.fire({"title":"نظر با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});
                        }

                    }
                });
            }
        }
        function confirm_comment(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/confirm_comment/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data) {
                            parent.remove();
                            Swal.fire({"title":"نظر با موفقیت تایید شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});
                        }

                    }
                });
            }
        }
    </script>
@endsection
