@extends("admin.theme.main")
@section('content')
@include('admin.import_xls.script')
    <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary" id="upload_xls_zone" style="display : {{ old('file_name') ? 'none' : 'block' }}">
        <div class="panel-heading">
            <h3 class="panel-title">بارگذاری فایل و تصویر جلد کتاب</h3>
        </div>
        <div class="panel-body">

            <div class="form-group col-md-12">

                <div class="col-md-12 ls-group-input">
                    <p class="alert alert-info">لطفا توجه داشته باشید که فایل اکسل آپلودی فقط دارای یک برگه (sheet) باشد. </p>

                    <input name="xls_file" id="import_xls_browse" type="file" multiple>
                </div>
            </div>


        </div>
    </div>

    <div class="panel panel-primary" style="display: {{ old('file_name') ? 'block' : 'none' }}"  id="select_column">
        <div class="panel-heading">
            <h3 class="panel-title">انتخاب ستون ها برای انتقال به دیتابیس </h3>
        </div>
        <div class="panel-body">
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
            </div>
            <section class="row component-section">

                <!-- responsive table title and description -->

                <!-- responsive table code and example -->

                <form style="" class="ls_form"  action="{{ URL::to('admin/import_excels_column') }}" method="post" enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <div class="form-group col-md-4">
                            <label>انتخاب ورودی ISBN</label>
                            <select id="select_user_1" name="isbn"  class="demo-default" placeholder="انتخاب ورودی شابک (ISBN)">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>شماره قفسه</label>
                            <select id="select_user_2" name="shelf_id"  class="demo-default" placeholder="انتخاب ورودی شماره قفسه ">
                            </select>
                        </div>

                        <input type="hidden" name="file_name" id="file_name" value="{{ old('file_name') }}" >
                        <input type="hidden" name="options" id="list_options" value="{{ old('options') }}" >

                        <div class="form-group col-md-4">
                            <label> قیمت کتاب بدون تخفیف </label>
                            <select id="select_user_3" name="show_price"  class="demo-default" placeholder="انتخاب ورودی قیمت کتاب بدون تخفیف">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>قیمت کتاب با تخفیف ( قیمت نهایی )</label>
                            <select id="select_user_4" name="price"  class="demo-default" placeholder="انتخاب ورودی قیمت نهایی کتاب">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>تعداد کتب موجود در انبار</label>
                            <select id="select_user_5" name="count"  class="demo-default" placeholder="انتخاب ورودی موجودی انبار">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>قابلیت فروش</label>
                            <select id="select_user_6" name="saleable"  class="demo-default" placeholder="انتخاب ورودی قابلیت فروش">
                                <option value="true_available"> اعمال قابلیت فروش برای همه </option>
                                <option value="false_available"> اعمال قابلیت فروش برای هیچ یک </option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success btn-block" style="">شروع عملیات انتقال به دیتابیس</button>
                        </div>
                    </div>


                </form>

            </section>



        </div>
    </div>
    <script>
        function remove_book(sender, id) {
            if (confirm("آیا مطمعن هستید؟")) {
                sender = $(sender);
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/remove_assigned_book/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log('success');
                        console.log(data);
                        parent.remove();
                        Swal.fire({"title":"محتوا با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                    },
                    error: function (data) {
                        console.log('error');
                        console.log(data);
                    }
                });
            }
        }
        function toggleSelect(sender, id) {
            if (confirm("آیا مطمعن هستید ؟")) {
                sender = $(sender);
                var child = sender.find('i');
                var parent = sender.parentsUntil('.cat_row').parent();
                $.ajax("/admin/toggleSelect_assigned_book/" + id, {
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);

                        if (child.hasClass('fa-star-o'))
                            child.removeClass('fa-star-o').addClass('fa-star');
                        else
                            child.removeClass('fa-star').addClass('fa-star-o');


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            }
        }


    </script>
@endsection
