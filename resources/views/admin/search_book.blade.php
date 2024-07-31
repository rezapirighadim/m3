@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedCategories) && $requestedCategories !== null) {
        $ready = true;
        $reqCat = $requestedCategories;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم جستجو و اضافه کردن کتاب</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    {{--<form class="ls_form" role="form" action="{{ URL::to('admin/news') }}" method="post" enctype="multipart/form-data">--}}
                    {{--{!! csrf_field() !!}--}}

                    <input type="hidden" name="edit"  value="<?=($ready ? $reqCat['id'] : "0")?>">

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
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <p style="margin-top: 10px; margin-right: -10px">جستجو بر اساس : </p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="radio">
                                            <input checked class="icheck-square-green" type="radio" name="radioRedCheckbox"
                                                   data-value="title" value="type"> نام کتاب
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="radio">
                                            <input class="icheck-square-green" type="radio" name="radioRedCheckbox"
                                                   data-value="isbn" value="type"> شابک
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>برای جستجو تایپ کنید <i id="spinner" style="display: none" class="fa fa-spin fa-spinner"></i></label>
                                        <input id="title" name="search_term" class="form-control"  placeholder="جستجو">
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>

                    {{--</form>--}}
                </div>
            </div>






            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"> نتایج جستجو </h3>
                </div>
                <div class="panel-body">
                    <section class="row component-section" style="margin-top: -13px ; margin-bottom: -45px">

                        <!-- responsive table title and description -->

                        <!-- responsive table code and example -->
                        <div class="">
                            <!-- responsive table example -->
                            <div class="pmd-card pmd-z-depth pmd-card-custom-view">
                                <table id="" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>شناسه کتاب</th>
                                        <th>تصویر</th>
                                        <th>نام کتاب</th>
                                        <th>شابک</th>
                                        <th>عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody id="example2">

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
        $(document).ready(function () {

            $.ajaxSetup({

                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $('#title').bind('keyup change ', function(){
                var title = $(this).val();
                if (!title) {
                    $('#spinner').css('display', 'none');
                    fill_table([]);
                }


                var fieldType = null;
                $('input:checked').each(function() {
                    fieldType = $(this).attr('data-value');
                });

                if (title.length >= 3){
                    $('#spinner').css('display', 'inline-block');

                    $.ajax({
                        // method: 'POST' ,
                        type:'POST',
                        url:"{{url('/admin/search_book')}}",
                        data:{
                            type: fieldType ,
                            value : title ,
                        },
                        success: function (data) {
                            $('#spinner').css('display', 'none');
                            if(data)
                            fill_table(data);
                        },error :  function (e) {
                            // console.log(e);
                        }
                    });

                }


            });

        });


        function fill_table(data) {

            var r = new Array(), j = -1;
            for (var key=0, size=data.length; key<size; key++){
                r[++j] ='<tr><td>';
                r[++j] = data[key].id;
                r[++j] = '</td><td class="whatever1">';
                // r[++j] = data[key].imageName;
                r[++j] = '<img style="width: 80px ; border-radius: 1%" src="{{URL::to("/local/uploads/books/images")}}/'+ data[key].imageName +'" alt="">';
                r[++j] = '</td><td class="whatever2">';
                r[++j] = data[key].title;
                r[++j] = '</td><td class="whatever2">';
                r[++j] = data[key].isbn;
                r[++j] = '</td><td class="whatever2">';
                r[++j] = '<a class=" label label-warning" href="/admin/assign_book/' + data[key].id + '">اضافه کردن به فروشگاه</a>';
                r[++j] = '</td></tr>';
            }
            $('#example2').html(r.join(''));

        }
    </script>
    <script>
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    </script>
@endsection
