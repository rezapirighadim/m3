@extends('admin.theme.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <a class="btn btn-primary btn-block" href="/admin/book_contents/{{$book_id}}/{{$content_id}}">ویرایش مجدد همین کتاب</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-warning btn-block" href="/admin/book_contents/{{$book_id}}">بازگشت</a>
            </div>
            <br>
            <br>
            <hr>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            {!! $content !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <a class="btn btn-primary btn-block" href="/admin/book_contents/{{$book_id}}/{{$content_id}}">ویرایش مجدد همین کتاب</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-warning btn-block" href="/admin/book_contents/{{$book_id}}">بازگشت</a>
            </div>            <br>
            <br>
            <hr>
        </div>

    </div>

@endsection
