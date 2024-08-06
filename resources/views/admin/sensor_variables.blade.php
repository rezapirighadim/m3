@extends('admin.theme.main')
@section('content')

    <?
    $ready = false;
    if (isset($requestedData) && $requestedData !== null) {
        $ready = true;
        $reqData = $requestedData;
    }
//dump($receptions);
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ثبت متغییرهای سنسور</h3>
                </div>
                <div class="panel-body">
                    <?= (isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "") ?>
                    <?= (isset($error) ? "<p class=\"alert alert-danger\">$error</p>" : "") ?>

                    <form class="ls_form" role="form" action="{{ URL::to('admin/sensor_variables') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="edit" value="<?=($ready ? $reqData['id'] : "0")?>">
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

                        <div class="row">
                            <div class="col-md-6">
                                <label>جستجو و انتخاب سنسور </label>
                                <select id="select_user_1" name="sensor_id" class="demo-default"
                                        placeholder="جستجو و انتخاب سنسور">
                                    <option>انتخاب کنید</option>
                                    @foreach ($sensors as $record)
                                        <option
                                            value="{{$record['id']}}"  {{$ready && $reqData['sensor_id'] == $record['id'] ? 'selected' : ''}}>{{$record['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ایندکس استخراج UUID</label>
                                    <input type="text" class="form-control "
                                           name="uuid_index" value="<?=($ready ? $reqData['uuid_index'] : "")?>"
                                           placeholder="uuid" id="long">
                                </div>
                            </div>
                            <hr>
                        </div>


                        <hr>

                        <p class="guild_p">
                            <span class="add_btn" onclick="add_creator(this)"> + </span>
                            <span class="red">برای اضافه کردن متغییر و آستانه هشدار روی <span class="green">+</span> کلیک کنید.</span>
                        </p>
                        <hr>

                        <div class="row col-md-12" id="book_creator">
                            @if ($ready && $reqData['alert_index'])
                                @foreach(json_decode($reqData['alert_index'] , true)  as $key => $value)
                                    <div class="variables">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control "
                                                       name="variables[{{$key}}][index]" value="{{$value['index']}}"
                                                       placeholder="index متغییر عینا وارد شود" id="long">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" class="form-control "
                                                       name="variables[{{$key}}][threshold]"
                                                       value="{{$value['threshold']}}"
                                                       placeholder='حد آستانه برای هشدار را وارد کنید' id="long">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="delete_btn" onclick="remove_creator(this)"> x </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>


                        <hr>

                        <button type="submit"
                                class="btn btn-block <?=(!$ready ? "btn-primary" : "btn-success")?>"> <?= (!$ready ? "ثبت " : "ویرایش") ?> </button>

                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">لیست متغییر ها </h3>
                </div>
                <div class="panel-body">

                    <section class="row component-section">

                        <!-- responsive table title and description -->

                        <!-- responsive table code and example -->
                        <div class="col-md-12">
                            <!-- responsive table example -->
                            <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                <table id="example"
                                       class="table pmd-table table-hover table-striped  display responsive nowrap"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>شناسه</th>
                                        <th>نام سنسور</th>
                                        <th>ورژن سنسور</th>
                                        <th>مقادیر متغییر</th>
                                        <th>مشاهده</th>
                                        <th>عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?
                                    if (isset($records) && $records != null){
                                    foreach ($records as $item){
                                        ?>
                                    <tr class="cat_row">
                                        <td><?= $item['id']; ?></td>
                                        <td><?= $item['sensor']['name'] ?? ''; ?></td>
                                        <td><?= $item['sensor']['version'] ?? ''; ?></td>
                                        <td><?= json_encode($item['alert_index']); ?></td>
                                        <td>مشاهده</td>
                                        <td>
                                            <a style="text-decoration: none;cursor: pointer" ;
                                               href="/admin/sensor_variables/<?=$item['id'];?>"><span
                                                    class="label label-default">ویرایش</span></a>
                                            <a class=" label label-danger" onclick="remove(this , {{$record['id']}}  )">حذف</a>

                                        </td>
                                    </tr>
                                    <? }
                                    } ?>
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
                $.ajax("/admin/remove_sensor_variables/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        parent.remove();
                        Swal.fire({"title":"متغییرهای سنسور با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    }
                });
            }
        }

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        function add_creator() {
            var id = makeid(6);
            $("#book_creator").append("<div class='variables'>" +
                " <div class='col-md-5'>" +
                " <div class='form-group'>" +
                "<input type='text' class='form-control'  name='variables[" + id + "][index]' placeholder='نام متغییر عینا وارد شود'>" +
                " </div>" +
                " </div>" +
                "<div class='col-md-5'>" +
                "<div class='form-group'>" +
                "<input type='text' class='form-control' name='variables[" + id + "][threshold]' placeholder='حد آستانه برای هشدار را وارد کنید' >" +
                "</div>" +
                "</div>" +
                "<div class='col-md-2' ><span class='delete_btn' onclick='remove_creator(this)'> x </span></div>" +
                "</div>");

        }

        function remove_creator(element) {
            var sender = $(element);
            var parent = sender.parentsUntil('.variables').parent();
            parent.remove();
        }


        function copy_clip(element) {
            var range, selection, worked;

            if (document.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }

            try {
                var x = document.execCommand('copy');
                console.log(element.innerText);
                if (element.innerText) {
                    Swal.fire({
                        "title": "کپی شد!",
                        "text": "",
                        "timer": "1500",
                        "width": "1",
                        "heightAuto": true,
                        "padding": "1.25rem",
                        "animation": true,
                        "showConfirmButton": false,
                        "showCloseButton": true,
                        "toast": true,
                        "type": "success",
                        "position": "center"
                    });
                }

            } catch (err) {
                console.log('خطا! متن کپی نشد.');
                // alert('خطا! متن کپی نشد.');
            }
        }
    </script>
@endsection
