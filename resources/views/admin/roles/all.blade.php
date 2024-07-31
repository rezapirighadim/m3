@extends('admin.theme.main')

@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">
            <h2>نوع کاربری ها</h2>
            <div class="btn-group">
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-danger">ایجاد نوع کاربری</a>
                <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-info">بخش دسترسی ها</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>نام نوع کاربری</th>
                    <th>توضیحات</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->label }}</td>
                        <td>
                            <form action="{{ route('roles.destroy'  , ['id' => $role->id]) }}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="btn-group btn-group-xs">
                                    <a href="{{ route('roles.edit' , ['id' => $role->id]) }}"  class="btn btn-primary">ویرایش</a>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $roles->render() !!}
        </div>
    </div>
@endsection
