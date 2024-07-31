@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="panel panel-default">
                                    <div class="panel-heading">اطلاعات تماس</div>
                                    <div class="panel-body">

                                        <div class="col-md-12">
                                            <p><span class="red">شماره تماس : </span>02166965272</p>
                                            <p><span class="red">ایمیل ما : </span>info@mayamey.com</p>
                                            <p><span class="red">آدرس ما : </span> انقلاب خیابان فخر رازی خ وحید نظری شرقی پلاک ۶۱ بلوک ب واحد ۲۳</p>
                                        </div>

                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">پیگیری جواب پیام های قبلی</div>
                                    <div class="panel-body">

                                        <div class="col-md-12">
                                            <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">

                                                <form class="form-horizontal" method="POST" action="{{ URL::to('tracking_message') }}">
                                                    {{ csrf_field() }}

                                                    <div class="col-md-10 col-md-offset-1">
                                                        <input id="reference" placeholder="کد پیگیری" type="text" class="form-control" name="reference" value="{{ old('reference') }}" required >

                                                        @if ($errors->has('reference'))
                                                            <span class="help-block">
                                                            <strong>{{ $errors->first('reference') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="col-md-8 col-md-offset-1">
                                                        {!! app('captcha')->display($attributes = [], $options = ['lang'=> 'fa'])!!}

                                                    </div>

                                                    <div class="form-group" style="margin-top: 100px">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <button type="submit" class="btn btn-primary btn-block">
                                                               پیگیری پیام
                                                            </button>
                                                        </div>
                                                    </div>


                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-7 ">
                                <div class="panel panel-default">
                                    <div class="panel-heading">فرم تماس باما</div>
                                    <div class="panel-body">
                                        <form class="form-horizontal" method="POST" action="{{ URL::to('contact_us') }}">
                                            {{ csrf_field() }}

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
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                <div class="col-md-8 col-md-offset-2">
                                                    <input id="name" placeholder="نام و نام خانوادگی" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                                <div class="col-md-8 col-md-offset-2">
                                                    <input id="email" placeholder="آدرس ایمیل" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                                <div class="col-md-8 col-md-offset-2">
                                                    <input id="phone" placeholder="شماره تماس" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                                    @if ($errors->has('phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">

                                                <div class="col-md-8 col-md-offset-2">
                                                    <textarea placeholder="متن پیام" rows="10" id="body"  class="form-control" name="body" required>{{ old('body') }}</textarea>

                                                    @if ($errors->has('body'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('body') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="col-md-8 col-md-offset-2">
                                                {!! app('captcha')->display($attributes = [], $options = ['lang'=> 'fa'])!!}

                                            </div>

                                            <div class="form-group" style="margin-top : 110px">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        ارسال پیام
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
