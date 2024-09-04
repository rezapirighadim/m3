@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedSensors) && $requestedSensors !== null) {
        $ready = true;
        $requestedData = $requestedSensors;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ایجاد سنسور</h3>
                </div>
                <div class="panel-body">
                    @php (isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "") @endphp
                    <form class="ls_form" role="form" action="{{ URL::to('admin/sensors') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">

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
                                    <label>عنوان سنسور</label>
                                    <input name="name" class="form-control" value="<?=($ready ? $requestedData['name'] : "")?>" placeholder="نام سنسور مورد نظر را برای ایجاد وارد کنید .">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>شناسه اختصاصی (UUID)</label>
                                    <input name="uuid" class="form-control ltr mono_font" value="<?=($ready ? $requestedData['uuid'] : "")?>" placeholder="uuid">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ورژن سنسور</label>
                                    <input name="version" class="form-control  ltr mono_font" value="<?=($ready ? $requestedData['version'] : "")?>" placeholder="Sensor Version (ex : v1.02.32)">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>تاپیک دریافت داده ها</label>
                                    <input name="receive_topic" class="form-control ltr mono_font" value="<?=($ready ? $requestedData['receive_topic'] : "")?>" placeholder="Receive Topic">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>تاپیک ارسال پاسخ</label>
                                    <input name="response_topic" class="form-control ltr mono_font" value="<?=($ready ? $requestedData['response_topic'] : "")?>" placeholder="Response Topic">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label>توضیحات</label>
                                    <textarea rows="5" name="description" class="form-control" id="book_content_editor"  placeholder="در صورت نیاز توضحیات مختصری را اینجا وارد کنید "><?=($ready ? $requestedData['description'] : "")?></textarea>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"> <?=(!$ready ? "ثبت سنسور " : "ویرایش")?> </button>
                        </div>
                    </form>
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">سنسور های ثبت شده </h3>
                </div>
                <div class="panel-body">
                    <section class="row component-section">

                        <!-- responsive table title and description -->

                        <!-- responsive table code and example -->
                        <div class="col-md-12">
                            <!-- responsive table example -->
                            <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                <table id="example" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام سنسور</th>
                                        <th>ورژن</th>
                                        <th>توضیحات</th>
                                        <th class="tac">نمایش کامل</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    @if(isset($records) && $records != null)
                                    @foreach($records as $record)
                                    <tr class="cat_row">
                                        <td>{{$record['id']}}</td>
                                        <td class="">{{ $record['name'] }}</td>
                                        <td class="">{{ $record['version'] }}</td>
                                        <td class="">
                                            @if($record['description'] != '')
                                                <a  class="popoverBox label label-light-green" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$record['description']}} ">مشاهده توضیحات</a>
                                            @else
                                                <span  class="label label-dark">فاقد توضیحات</span>
                                            @endif
                                        </td>

                                        <td class="tac">مشاهده</td>
                                        <td class="tac">
                                            <a style="text-decoration: none;cursor: pointer"; href="/admin/sensors/{{$record['id']}}" ><span  class="label label-default">ویرایش</span></a>
                                            <a class=" label label-danger" onclick="remove(this , {{$record['id']}}  )">حذف</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
    <script>
        function remove(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_sensor/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        parent.remove();
                        Swal.fire({"title":"سنسور با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    }
                });
            }
        }
        function note_edit() {

        }
    </script>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    </script>
@endsection
