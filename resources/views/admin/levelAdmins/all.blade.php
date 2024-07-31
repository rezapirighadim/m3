@extends('admin.theme.main')

@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">
            <h2>مدیران سایت</h2>
            <div class="btn-group">
                <a href="{{ route('level.create') }}" class="btn btn-sm btn-info">ثبت نوع کاربری برای کاربر</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>نام کاربر</th>
                    <th>ایمیل</th>
                    <th>نوع کاربری</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    @if(count($role->users))
                        @foreach($role->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $role->name }} - {{ $role->label }}</td>
                                <td>
                                    <form action="{{ route('level.destroy'  , ['id' => $user->id]) }}" method="post">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                        <div class="btn-group btn-group-xs">
                                            <a href="{{ route('level.edit' , ['id' => $user->id]) }}"  class="btn btn-primary">ویرایش</a>
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $roles->render() !!}
        </div>
    </div>
@endsection
