@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedDatas) && $requestedDatas !== null) {
        $ready = true;
        $requestedData = $requestedDatas;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم تنظیمات اتصال به MQTTT</h3>
                </div>
                <div class="panel-body">
                    @php (isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "") @endphp
                    <form class="ls_form" role="form" action="{{ URL::to('admin/mqtt_connection') }}" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit" value="<?=($ready ? $requestedData['id'] : "0")?>">

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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Client ID</label>
                                    <input name="client_id" class="form-control ltr mono"
                                           value="<?=($ready ? $requestedData['client_id'] : "")?>"
                                           placeholder="Insert Client ID">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Host</label>
                                    <input name="host" class="form-control ltr mono"
                                           value="<?=($ready ? $requestedData['host'] : "")?>"
                                           placeholder="Insert Host Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Port</label>
                                    <input name="port" class="form-control ltr mono"
                                           value="<?=($ready ? $requestedData['port'] : "")?>"
                                           placeholder="Insert Port">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input name="username" class="form-control ltr mono"
                                           value="<?=($ready ? $requestedData['username'] : "")?>"
                                           placeholder="Insert Username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>password</label>
                                    <input name="password" class="form-control ltr mono"
                                           value="<?=($ready ? $requestedData['password'] : "")?>"
                                           placeholder="Insert password">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info btn-block"> <?= (!$ready ? "ثبت تنظیمات " : "ویرایش") ?> </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
