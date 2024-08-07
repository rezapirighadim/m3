@extends('admin.theme.main')


@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">
            <h2>ویرایش دسترسی</h2>
        </div>
        <form class="form-horizontal" action="{{ route('permissions.update' , ['id' => $permission->id ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('admin.errors')
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="name" class="control-label">عنوان دسترسی</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="عنوان را وارد کنید" value="{{ $permission->name or old('name') }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="label" class="control-label">توضیحات کوتاه</label>
                    <textarea rows="5" class="form-control" name="label" id="label" placeholder="توضیحات را وارد کنید">{{ $permission->label or old('label') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-danger">ویرایش</button>
                </div>
            </div>
        </form>
    </div>
@endsection
