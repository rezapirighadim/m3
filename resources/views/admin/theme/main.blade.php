<?
$title = isset($title) ? $title : '';
$path = isset($path) ? $path : 'مدیریت وب سایت / ' . $title;
//$newMessages = AdminModel::getNewMessages($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="/../assets/js/lib/jquery-1.11.min.js"></script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="REZA PIRY GHADIM">
    <meta charset='utf-8'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Viewport metatags -->
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- iOS webapp metatags -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- iOS webapp icons -->
    <link rel="apple-touch-icon-precomposed" href="/../assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/../assets/images/ios/fickle-logo-72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/../assets/images/ios/fickle-logo-114.png" />

    <!-- TODO: Add a favicon -->
    <link rel="shortcut icon" href="/../assets/images/ico/fab.ico">

    <title><?=(isset($title)? $title : 'پنل ادمین')?></title>

    <!--Page loading plugin Start -->
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/pace-rtl.css">
    <script src="/../assets/js/pace.min.js"></script>
    <!--Page loading plugin End   -->

    <!-- Plugin Css Put Here -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="/../assets/css/bootstrap-rtl.css" >
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/bootstrap-progressbar-3.1.1-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/jquery-jvectormap-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/selectize.bootstrap3-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/summernote-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/accordion-rtl.css">
    <link rel="stylesheet" href="/../assets/css/plugins/icheck/skins/all.css">
    <link rel="stylesheet" href="/../assets/css/font-awesome/css/font-awesome-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/tab-rtl.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/persian-datepicker-cheerup.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/selectize.bootstrap3-rtl.css">





    <!--AmaranJS Css Start-->
    <link href="/../assets/css/rtl-css/plugins/amaranjs/jquery.amaran-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/all-themes-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/awesome-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/default-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/blur-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/user-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/rounded-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/readmore-rtl.css" rel="stylesheet">
    <link href="/../assets/css/rtl-css/plugins/amaranjs/theme/metro-rtl.css" rel="stylesheet">
    <!--AmaranJS Css End -->

    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/propeller.min.css">


    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/select.dataTables.min.css">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/pmd-datatable.css">


    <!-- Plugin Css End -->
    <!-- Custom styles Style -->
    <link href="/../assets/css/rtl-css/style-rtl-default.css" rel="stylesheet">
    <link rel="stylesheet" href="/../assets/css/rtl-css/plugins/fileinput-rtl.css">
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />--}}

    <!-- Custom styles Style End-->

    <!-- Responsive Style For-->
    <link href="/../assets/css/rtl-css/responsive-rtl.css" rel="stylesheet">
    <!-- Responsive Style For-->

    <!-- Custom styles for this template -->

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">--}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="blue-color">
<!--Navigation Top Bar Start-->
<nav class="navigation">
    <div class="container-fluid">
        <!--Logo text start-->
        <div class="header-logo">
            <a href="/admin" title="">
                <h1 style="font-size: 12pt">پنل مدیریت </h1>
            </a>
        </div>
        <!--Logo text End-->
        <div class="top-navigation">
            <!--Collapse navigation menu icon start -->

            {{--<div class="menu-control hidden-xs">--}}
            <div class="menu-control ">
                <a href="javascript:void(0)">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="search-box">
                <ul>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                            <span class="fa fa-search"></span>
                        </a>
                        <div class="dropdown-menu  top-dropDown-1">
                            <h4>جستجو</h4>
                            <form>
                                <input type="search" placeholder="چه چیزی را میخواهی ببینی ؟">
                            </form>
                        </div>

                    </li>
                </ul>
            </div>

            <!--Collapse navigation menu icon end -->
            <!--Top Navigation Start-->

            <ul>
                <li class="dropdown">
                    <!--Email drop down start-->
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">
                        <span class="fa fa-envelope-o"></span>
                        <?if(isset($newMessages) && count($newMessages)>0){?>
                        <span class="badge badge-red"><?=convert2persian(count($newMessages))?></span>
                        <?}?>
                    </a>

                    <div class="dropdown-menu right email-notification">
                        <h4>پیام ها :</h4>
                        <ul class="email-top">
                            <? if(isset($newMessages) && $newMessages !== null && count($newMessages)>0){
                            $i=0;
                            foreach ($newMessages as $new){
                            $i++;
                            if($i>10){
                                break;
                            }
                            ?>
                            <li>
                                <a href="/admin/messageList">
                                    <div class="email-top-image">
                                        <img class="rounded" src="/assets/images/userimage/mail-flag-icon.png" alt="user image" />
                                    </div>
                                    <div class="email-top-content">
                                        <span style="font-size: small; color: #00A8EC;"><?=$new['title']?></span>
                                        <div><?=mb_substr($new['body'], 0, 68, 'utf-8') . " ..."?></div>
                                    </div>
                                </a>
                            </li>
                            <?}
                            }else{?>
                            <li>
                                <div style="color: #FF7878;text-align: center"> پیام جدیدی برای نمایش وجود ندارد !</div>
                            </li>
                            <?}
                            ?>


                            <li class="only-link">
                                <a href="/admin/messageList">مشاهده همه</a>
                            </li>
                        </ul>
                    </div>
                    <!--Email drop down end-->
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-lock"></i>
                    </a>
                </li>
                <li>
                    <a href="/logout">
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>

            </ul>
            <!--Top Navigation End-->
        </div>
    </div>
</nav>
<!--Navigation Top Bar End-->
<section id="main-container">
    <!--Left navigation section start-->
    <section id="left-navigation">
        <!--Left navigation user details start-->
        <div class="user-image">
            <!--            <img src="/assets/images/userimage/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.png" alt=""/>-->
            <!--            <div class="user-online-status"><span class="user-status is-online  "></span> </div>-->
        </div>
        <ul class="social-icon">
            <li><a href="https://www.facebook.com/mayamey_com/"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/mayamey_com"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://telegram.me/mayamey_com"><i class="fa fa-paper-plane"></i></a></li>
            <li><a href="https://www.instagram.com/mayamey_com"><i class="fa fa-instagram"></i></a></li>
        </ul>
        <!--Left navigation user details end-->

        <!--Phone Navigation Menu icon start-->
        <div class="phone-nav-box visible-xs">
            <a class="phone-logo" href="/admin" title="">
                <h1 style="font-size: 12pt">پنل مدیریت </h1>
            </a>
            <a class="phone-nav-control" href="javascript:void(0)">
                <span class="fa fa-bars"></span>
            </a>
            <div class="clearfix"></div>
        </div>
        <!--Phone Navigation Menu icon start-->

        <!--Left navigation start-->
        <ul class="mainNav" id="mainNav">

            <li ><a  href="/admin/index"><i class="fa fa-dashboard"></i> <span>داشبورد</span></a></li>


            <li><a href="/admin/sensors"><i class="fa fa-deviantart"></i> <span>سنسور</span></a></li>
            <li><a href="/admin/sensor_variables"><i class="fa fa-check"></i> <span>متغییر سنسور ها</span></a></li>
            <li><a href="/admin/mqtt_connection"><i class="fa fa-link"></i> <span>تنظیمات اتصال به MQTT</span></a></li>
            <li><a href="/admin/mqtt_messages"><i class="fa fa-database"></i> <span>داده های ورودی</span></a></li>
            <li><a href="/admin/mqtt_alerts"><i class="fa fa-bell"></i> <span>هشدارها</span></a></li>
            <li><a href="/admin/devices"><i class="fa fa-users"></i> <span> سخت افزار ها </span></a></li>
            <li><a href="/admin/change_password"><i class="fa fa-key"></i> <span>تغییر رمز عبور</span></a></li>
            <li><a href="/logout"><i class="fa fa-sign-out"></i> <span>خروج از سیستم</span></a></li>


        </ul>
        <!--Left navigation end-->
    </section>
    <!--Left navigation section end-->


    <!--Page main section start-->
    <section id="min-wrapper">
        <div id="main-content">
            <div class="container-fluid" id="app_vue">
                <div class="row">
                    <div class="col-md-12">
                        <!--Top header start-->
                        <h3 class="ls-top-header"><?=$path?></h3>
                        <!--Top header end -->

                        <!--Top breadcrumb start -->
                        <ol class="breadcrumb">
                            <li><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="active"><?=$path?></li>
                        </ol>
                        <!--Top breadcrumb start -->
                    </div>
                </div>
                <!-- Main Content Element  Start-->
                <div>
                    @yield('content')
                </div>

                <!-- Main Content Element  End-->

            </div>
        </div>



    </section>
    <!--Page main section end -->
    <!--Right hidden  section start-->


    <!--    deleted    -->


    <!--Right hidden  section end -->
    {{--<div id="change-color">--}}
        {{--<div id="change-color-control">--}}
            {{--<a href="javascript:void(0)"><i class="fa fa-magic"></i></a>--}}
        {{--</div>--}}
        {{--<div class="change-color-box">--}}
            {{--<ul>--}}
                {{--<li class="default active"></li>--}}
                {{--<li class="red-color"></li>--}}
                {{--<li class="blue-color"></li>--}}
                {{--<li class="light-green-color"></li>--}}
                {{--<li class="black-color"></li>--}}
                {{--<li class="deep-blue-color"></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}
</section>

<!--Layout Script start -->



<script type="text/javascript" src="/../assets/js/lib/jquery-1.11.min.js"></script>

<!-- Script For Icheck -->
<script src="/../assets/js/icheck.min.js"></script>
<!-- Script For Icheck -->


<!--Advance Radio and checkbox demo start-->
<script src="/../assets/js/pages/checkboxRadio.js"></script>
<!--Advance Radio and checkbox demo start-->


<!--Tab Library Script Start -->
<script src="/../assets/js/tabulous.js"></script>
<!--Tab Library Script End -->

<script src="/../assets/js/datePikerAll.js"></script>


<script type="text/javascript" src="/../assets/js/color.js"></script>

<script type="text/javascript" src="/../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/../assets/js/multipleAccordion.js"></script>

<!--easing Library Script Start -->
<script src="/../assets/js/lib/jquery.easing.js"></script>
<!--easing Library Script End -->

<!--Nano Scroll Script Start -->
<script src="/../assets/js/jquery.nanoscroller.min.js"></script>
<!--Nano Scroll Script End -->

<!--switchery Script Start -->
<script src="/../assets/js/switchery.min.js"></script>
<!--switchery Script End -->

<!--bootstrap switch Button Script Start-->
<script src="/../assets/js/bootstrap-switch.js"></script>
<!--bootstrap switch Button Script End-->

<!--easypie Library Script Start -->
<script src="/../assets/js/jquery.easypiechart.min.js"></script>
<!--easypie Library Script Start -->

<!--bootstrap-progressbar Library script Start-->
<script src="/../assets/js/bootstrap-progressbar.min.js"></script>
<!--bootstrap-progressbar Library script End-->

<!--FLoat library Script Start -->
<script type="text/javascript" src="/../assets/js/chart/flot/jquery.flot.js"></script>
<script type="text/javascript" src="/../assets/js/chart/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="/../assets/js/chart/flot/jquery.flot.resize.js"></script>
<!--FLoat library Script End -->

<!--Morris Chart library Script Start -->
<!--<script src="--><?//=ADDR;?><!--../..//../assets/js/chart/morris.min.js"></script>-->
<!--<script src="--><?//=ADDR;?><!--../..//../assets/js/chart/raphael-min.js"></script>-->
<!--Morris Chart library Script End -->

<!--Morris Demo  Script Start-->
<!--<script src="--><?//=ADDR;?><!--../..//../assets/js/pages/demo.morris.js"></script>-->
<!--Morris Demo  Script Start-->

<script type="text/javascript" src="/../assets/js/pages/layout.js"></script>
<!--Layout Script End -->



<script src="/../assets/js/countUp.min.js"></script>

<!-- skycons script start -->
<script src="/../assets/js/skycons.js"></script>
<!-- skycons script end   -->

<!--Vector map library start-->
<script src="/../assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/../assets/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!--Vector map library end-->

<!--AmaranJS library script Start -->
<script src="/../assets/js/jquery.amaran.js"></script>
<!--AmaranJS library script End   -->

<script src="/../assets/js/pages/dashboard.js"></script>
<script src="/../assets/js/lib/jquery_cookie.js"></script>



<!--selectize Library start-->
<script src="/../assets/js/selectize.min.js"></script>
<!--selectize Library End-->

<!--Select & Tag demo start-->
<script src="/../assets/js/pages/selectTag.js"></script>
<!--Select & Tag demo end-->

<script src="/../assets/js/propeller.min.js"></script>

<!--dataTables start-->

<script src="/../assets/js/jquery.dataTables.min.js"></script>
<script src="/../assets/js/dataTables.bootstrap.min.js"></script>
<script src="/../assets/js/dataTables.responsive.min.js"></script>
<script src="/../assets/js/dataTables.select.min.js"></script>

<script src="/../assets/js/fileinput.min.js" charset="utf-8"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>--}}
<script src="/../assets/js/jquery.autosize.js"></script>
<script src="/../assets/js/pages/sampleForm.js"></script>


{{--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAiLQcqNnf_JCTZ1jxbM7WOAapr41vZw94"></script>--}}

<!--dataTables end-->


<script src="/../assets/js/summernote.min.js"></script>
<script>
    $(".summernote").summernote({
        height: 150,
        minHeight: null,
        maxHeight: null,
        focus: true,
        codemirror: {
            theme: "monokai"
        }
    });

    $(".bookContents").summernote({
        height: 500,
        minHeight: null,
        maxHeight: null,
        focus: true,
        codemirror: {
            theme: "monokai"
        }
    });
</script>


<script>
    var checkCookie = $.cookie("nav-item");
    if (checkCookie != "") {
        $('#mainNav > li:eq(' + checkCookie + ')').addClass('active').next().show();
        $('#mainNav > li > a:eq(' + checkCookie + ')').addClass('active').next().show();
    }

    $('#mainNav > li > ul > li > a').click(function () {
        var checkElement = $(this).next();
        $(this).removeClass('active');
        $(this).closest('li').addClass('testing');
        $('#mainNav li li .active').removeClass('active');
        $(this).addClass('active');
    });

    $('#mainNav > li > a').click(function () {
        var navIndex = $('#mainNav > li > a').index(this);
        $.cookie("nav-item", navIndex);
        $('#mainNav li').removeClass('active');
        $('#mainNav li a').removeClass('active');

        $(this).addClass('active');
    });
</script>
<script src="/../assets/js/main.js"></script>
<script src="/../assets/js/compressedNotify_all.js"></script>
<script src="/../assets/js/dropzone.js"></script>
<script src="/../assets/lib/ckeditor/ckeditor.js"></script>
<script src="/../assets/js/resumable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

<!--Demo ui element Script Start -->
<script>
    tabulous_trigger_call();
    function tabulous_trigger_call() {
        $("#tabs").tabulous({
            effect: "scale"
        });
        $("#tabs2").tabulous({
            effect: "slideLeft"
        });
        $("#tabs3").tabulous({
            effect: "scaleUp"
        })
    }
</script>
<!--Demo ui element Script End -->
<script src="/vendor/sweetalert/sweetalert.all.js"></script>

@include('sweetalert::alert')

</body>

</html>
