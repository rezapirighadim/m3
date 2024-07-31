@extends("admin.theme.main")
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">لیست کاربران موبایل </h3>
        </div>
        <div class="panel-body">
            <div class="row col-md-12">
                <p class="alert alert-info">
                    <span>برای دریافت خروجی Excel کاربران کلیک کنید </span>
                    <a href="/admin/mobile_users/get_excel" class="btn btn-success btn-sm"><i class="fa fa-table"></i> دریافت خروجی </a>
                </p>
            </div>
            <section class="row component-section">
                <div class="col-md-12">
                    <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                        <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>شناسه</th>
                                <th class="tac">نام کاربر</th>
                                <th class="tac"> موبایل</th>
                                <th class="tac">تاریخ ثبت</th>
                                <th class="tac">نمایش کامل</th>
                                <th class="tac">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            if(isset($users) && $users!=null){
                            foreach($users as $user){?>
                            <tr class="cat_row">
                                <td class="tac"><?=$user['id'];?></td>
                                <td class="tac">{{$user['name']}} {{$user['family']}}</td>
                                <td class="tac"><?=$user['phone'];?></td>
                                <td class="tac"><?=piry_gregorian_to_jalali($user['created_at']);?></td>
                                <td class="tac">مشاهده</td>
                                <td class="tac">
                                    <a target="_blank"  class=" label label-warning" href="/admin/mobile_users/<?=$user['id']?>">مشاهده جزییات</a>

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

@endsection
