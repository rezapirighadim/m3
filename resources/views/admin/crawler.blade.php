@extends("admin.theme.main")
@section('content')

    <div class="row">
        <form role="form" class="ls_form" method="post" action="/admin/crawler">
            {!! csrf_field() !!}
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
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h3 class="panel-title">تنظیمات خزنده (کرالر)</h3>
                    </div>
                    <div class="panel-body">


                        <div class="col-md-4">
                            <p class="form-group">
                                <label> شناسه شروع</label>
                                <input value="{{check_var($start)}}" style="font-family: monospace" placeholder="Start ID" name="start" class="form-control ltr" type="text">
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="form-group">
                                <label>شناسه  پایان</label>
                                <input value="{{check_var($end)}}" style="font-family: monospace" placeholder="End ID" name="end" class="form-control ltr" type="text">
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p class="form-group">
                                <label>دفعات اجرای هر جاب</label>
                                <input value="{{check_var($job_count)}}" style="font-family: monospace" placeholder="JOB count" name="job_count" class="form-control ltr" type="text">
                            </p>
                        </div>



                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary btn-block" style="height: 35px;">ثبت تغییرات</button>
                </div>


            </div>

        </form>
    </div>

@endsection
