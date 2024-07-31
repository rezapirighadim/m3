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
                    <h3 class="panel-title">فرم ایجاد تغییرات کلی قیمت</h3>
                </div>
                <div class="panel-body">
                    <?=(isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "")?>
                    <form class="ls_form" role="form" action="{{ URL::to('admin/price_setting') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <input type="hidden" name="edit"  value="<?=($ready ? $reqCat['id'] : "0")?>">

                        <div class="row">
                            <div class="col-md-12">
                                <p class="alert alert-info">توجه داشته باشید که تمامی تغییراتی که اینجا اعمال میکنید بر روی قیمت های تمام کتاب های شما اعمال میشد.</p>
                                <p class="alert alert-info">در صورت خالی گذاشتن هر یک از موارد تغییرات قیمت در آن اعمال نخواهد شد.</p>
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
                                    <label>درصد قیمت نمایشی فیزیکی</label>
                                    <input name="show_price" class="form-control"  placeholder="عدد">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>درصد قیمت نمایشی دانلودی</label>
                                    <input name="show_price_in_app" class="form-control"  placeholder="عدد">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>درصد قیمت فیزیکی</label>
                                    <input name="price" class="form-control"  placeholder="عدد">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>درصد قیمت دانلودی</label>
                                    <input name="price_in_app" class="form-control"  placeholder="عدد">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-6">
                                        <label class="radio">
                                            <input class="icheck-red" type="radio" name="type"
                                                   id="radioRedCheckbox1" value="decrease" checked="checked"> کاهش
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="radio">
                                            <input class="icheck-black" type="radio" name="type"
                                                   id="radioRedCheckbox5" value="increase"> افزایش
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-block"> اعمال تغییرات قیمت </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

@endsection
