@extends('admin.theme.main')

@section('content')
    <div class="col-md-12">
        <div class="page-header head-section">

        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>نام کاربر</th>
                    <th>UUID</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->uuid }}</td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <button type="submit" class="btn btn-danger">تکمیل اطلاعات</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
