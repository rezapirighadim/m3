@extends('admin.theme.main')

@section('script')
    <script>
        $(document).ready(function () {
            $('#role_id').selectpicker();
        })
    </script>
@endsection


@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">
            <h2>ویرایش نوع کاربری</h2>
        </div>
        <form class="form-horizontal" action="{{ route('level.update' , ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('admin.errors')
            <div class="form-group">
                <div class="col-sm-12">
                    <label for="role_id" class="control-label"> نوع کاربری ها - {{ $user->email }}</label>
                    <select class="form-control" name="role_id" id="role_id">
                        @foreach(\App\Role::all() as $role)
                            <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }} - {{ $role->label }}</option>
                        @endforeach
                    </select>
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
