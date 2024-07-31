@extends("admin.theme.main")
@section('content')
    <div class="panel panel-red">
        <div class="panel-heading">
            <h3 class="panel-title">تغییر رمز عبور</h3>
        </div>



        <div class="panel-body">

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
            </div>


            <p class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                از انتخاب عبارات ساده که امکان حدس زدن آن ها ساده باشد  به شدت پرهیز کنید .
            </p>
            <p class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                برای اعمال تغییرات از منوی سایت بر روی خروج از سیستم کلیک کنید و مجددا وارد سایت شوید .
            </p>
            <form role="form" class="ls_form" method="post" action="/admin/change_password">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">

                        <p class="form-group">
                            <label>ایمیل شما</label>
                            <input placeholder="ایمیل شما" value="<?=auth()->user()->email?>" disabled="disabled" class="form-control disabled" type="text">
                        </p>
                        <p class="form-group">
                            <label>رمز عبور فعلی</label>
                            <input placeholder="رمز عبور فعلی" name="currentPassword" class="form-control" type="password">
                        </p>
                        <p class="form-group">
                            <label>رمز عبور جدید</label>
                            <input placeholder="رمز عبور جدید" name="password" class="form-control" type="password">
                        </p>
                        <p class="form-group">
                            <label>تکرار رمز عبور جدید</label>
                            <input placeholder="تکرار رمز عبور جدید" name="password_confirmation" class="form-control" type="password">
                        </p>

                        <p class="form-group">
                            <button class="btn btn-sm btn-default" type="submit">ارسال</button>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
