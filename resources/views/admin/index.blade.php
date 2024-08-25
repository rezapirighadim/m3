@extends('admin.theme.main')
@section('content')
    @php
        $free_book = 1;
        $book_content_count= 22;
        $app_install= 22;
        $user_count= 22;
    @endphp

    <style>
        /* Flex container for all elements in a single line */
        .alert {
            display: flex;
            align-items: center;
        }

        /* Style for the dot container */
        .dot-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
        }

        /* Ensure the dot is aligned in the center */
        #center-div {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Base style for the dot */
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(0, 255, 0, 0.4);
            animation: dot-pulse 1.5s linear infinite;
        }

        .mx-2 {
            margin-left: 8px;
            margin-right: 8px;
        }

        /* Pulse animation */
        @keyframes dot-pulse {
            0% {
                transform: scale(1);
                opacity: 0.75;
            }
            25% {
                transform: scale(1);
                opacity: 0.75;
            }
            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="alert  d-flex align-items-center justify-content-start">
                <span>وضعیت اتصال به شبکه اینترنت اشیا :</span>
                <div id="center-div" class="dot-container mx-2">
                    <div class="dot online"></div>
                </div>
                <span id="status_title" class="green">آنلاین</span>
            </div>
            <hr>
            <br>
        </div>
        <div class="col-md-12">
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-1" class="chart-pie-widget" data-percent="{{get_percent($book_count ?? '1' , $book_limit ?? '1' )}}">
                        <span class="pie-widget-count-1 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل پیام های دریافتی یک ساعت اخیر: <span class="red">{{$free_book  ?? '1'}}</span> </p>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-2" class="chart-pie-widget" data-percent="{{get_percent($book_count ?? '1' , $free_book  ?? '1' )}}">
                        <span class="pie-widget-count-2 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل پیام های دریافتی کل: <span class="red">{{$free_book  ?? '1'}}</span> </p>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-3" class="chart-pie-widget" data-percent="{{get_percent($book_count ?? '1' , $book_content_count )}}">
                        <span class="pie-widget-count-3 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل هشدارهای دریافتی یک ساعت اخیر: <span class="red">{{$free_book  ?? '1'}}</span> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-4" class="chart-pie-widget" data-percent="{{get_percent($app_install , $user_count )}}">
                        <span class="pie-widget-count-4 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل هشدارهای دریافتی: <span class="red">{{$free_book  ?? '1'}}</span> </p>
                    </div>


                </div>
            </div>

        </div>
    </div>


    <br>
    <br>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">داده های دریافتی</h3>
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
                                    <th>شناسه</th>
                                    <th class="tac">تاپیک</th>
                                    <th class="tac">ای دی سخت افزار</th>
                                    <th class="tac">ای دی سنسور</th>
                                    <th class="tac">نمایش کامل</th>
                                    <th class="tac">مقدار دریافتی</th>
                                    <th class="tac">مقدار ارسالی</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?
                                if(isset($mqtt_messages) && $mqtt_messages!=null){
                                foreach($mqtt_messages as $mqtt_message){?>
                                <tr class="cat_row">
                                    <td>{{$mqtt_message['id']}}</td>
                                    <td class="tac">{{$mqtt_message['topic']}}</td>
                                    <td class="tac">{{$mqtt_message['device_id']}}</td>
                                    <td class="tac">{{$mqtt_message['sensor_id']}}</td>
                                    <td class="tac">-</td>

                                    <td class="tac">{{$mqtt_message['received_data']}}</td>
                                    <td class="tac">{{$mqtt_message['sent_data']}}</td>
                                </tr>
                                <?}}?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </section>



            </div>
        </div>
    </div>


@endsection
