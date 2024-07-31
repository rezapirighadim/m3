@extends('admin.theme.main')

@section('script')
    <script>
        $(document).ready(function () {
            $('#permission_id').selectpicker();
        })
    </script>
@endsection


@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">
            <h2>ویرایش نوع کاربری</h2>
        </div>
        <form class="form-horizontal" action="{{ route('roles.update' , ['id' => $role->id ]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            @include('admin.errors')
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="name" class="control-label">عنوان نوع کاربری</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="عنوان را وارد کنید" value="{{ $role->name or old('name') }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="permission_id" class="control-label">دسترسی ها</label>
                    <select class="form-control" name="permission_id[]" id="permission_id" multiple>
                        @foreach(\App\Permission::latest()->get() as $permission)
                            <option value="{{ $permission->id }}" {{ in_array(trim($permission->id) , $role->permissions->pluck('id')->toArray()) ? 'selected' : ''  }}>{{ $permission->name }} - {{ $permission->label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="label" class="control-label">توضیحات کوتاه</label>
                    <textarea rows="5" class="form-control" name="label" id="label" placeholder="توضیحات را وارد کنید">{{ $role->label or old('label') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-danger">ارسال</button>
                </div>
            </div>
        </form>
    </div>
@endsection
