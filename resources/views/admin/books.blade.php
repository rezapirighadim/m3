@extends('admin.theme.main')
@section('content')

    <?
    $ready = false;
    if (isset($requestedBook) && $requestedBook !== null) {
//        dd($requestedBook);
        $ready = true;
        $reqBook = $requestedBook;
    }
    ?>
    @include('admin.books.script')
    <?if(isset($AffectedRows) && $AffectedRows){?>

    <div class="alert alert-success" style="margin-bottom: 0px !important;">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        محصول شما با موفقیت ارسال شد .
    </div>

    <?}?>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ثبت کتاب در </h3>
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



                    <ul class="nav nav-tabs " >
                        <li class="active"><a style="background-color:transparent ;opacity:1 !important;"  href="#home" data-toggle="tab"><span>اطلاعات کلی کتاب</span></a></li>
                        <li ><a class="tabs_style"  href="#price" data-toggle="tab"><span>وضعیت و قیمت</span></a></li>
                        <li ><a class="tabs_style"  href="#extra_data" data-toggle="tab"><span>اطلاعات تکمیلی</span></a></li>
                        <li ><a class="tabs_style"  href="#preview" data-toggle="tab"><span>پیش نمایش و تصویر</span></a></li>
                        <li ><a class="tabs_style"  href="#pod" data-toggle="tab"><span>POD</span></a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content " style=";background: none;">

                        <form style="" class="ls_form"  action="{{ URL::to('admin/books') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}
                        <input type="hidden" name="edit" id="eddit" value="<?=($ready ? $reqBook['id'] : "0")?>">
                            @include('admin.books.tab_index')
                            @include('admin.books.tab_price')
                            @include('admin.books.tab_extra_data')
                            @include('admin.books.tab_preview')
                            @include('admin.books.tab_pod')

                        </form>






                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
