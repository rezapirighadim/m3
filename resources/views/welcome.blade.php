<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<title>Mqtt Panel</title>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        *{
            font-family: IRANSans;
        }
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        .laraFont { font-family: 'Raleway', sans-serif !important; }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a class="laraFont" href="{{ url('/home') }}">Home</a>
            @else
                <a class="laraFont" href="{{ url('/login') }}">Login</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md laraFont" >
            Mqtt Panel
        </div>
        <p style="text-align: right ; font-family: 'Raleway', sans-serif;">welcome</p>
    </div>
</div>
</body>
</html>
@include('sweetalert::alert')
<script type="text/javascript" src="/../assets/js/lib/jquery-1.11.min.js"></script>
