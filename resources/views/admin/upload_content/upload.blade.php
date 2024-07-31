@extends("admin.theme.main")
@section('content')
@include('admin.upload_content.script')
    <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary" id="upload_xls_zone" style="display : {{ old('file_name') ? 'none' : 'block' }}">
        <div class="panel-heading">
            <h3 class="panel-title">بارگذاری محتوای کتاب</h3>
        </div>
        <div class="panel-body">

            <form class="ls_form" role="form" action="{{ URL::to('admin/upload_book_content') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <input type="hidden" name="book_id" value="{{$book_id}}" id="book_id">
                <input name="file"  type="file" multiple>
                <input type="submit" value="done">

            </form>
                <div class="form-group col-md-12">

                <div class="col-md-12 ls-group-input">
                    <p class="alert alert-info">لطفا توجه داشته باشید فایل آپلودی شامل یک فایل به نام index.html باشد.</p>
                    <p class="alert alert-warning">قبل از گرفتن خروجی از فایل ورد حتما نام فایل را به یک نام انگلیسی و بدون فاصله تغییر بدید و بعد خروجی بگیرید.</p>


                    <input type="hidden" value="{{$book_id}}" id="book_id">
                    <input name="file" id="import_content_browse" type="file" multiple>
                </div>
            </div>


        </div>
    </div>

    <div class="panel panel-primary" style="display: {{ old('file_name') ? 'block' : 'none' }}"  id="select_column">
        <div class="panel-heading">
            <h3 class="panel-title">انتخاب ستون ها برای انتقال به دیتابیس </h3>
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
            <section class="row component-section">


                    {!! csrf_field() !!}

            </section>



        </div>
    </div>
@endsection
