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
                    <div id="pie-widget-1" class="chart-pie-widget"
                         data-percent="{{get_percent($book_count ?? '1' , $book_limit ?? '1' )}}">
                        <span class="pie-widget-count-1 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar">
                            تعداد کل پیام های دریافتی یک ساعت اخیر: <span id="messages_last_hour"
                                class="red">{{$messages_last_hour  ?? '1'}}</span></p>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-2" class="chart-pie-widget"
                         data-percent="{{get_percent($book_count ?? '1' , $free_book  ?? '1' )}}">
                        <span class="pie-widget-count-2 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل پیام های دریافتی کل: <span id="messages_total" class="red">{{$messages_total  ?? '0'}}</span>
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-3" class="chart-pie-widget"
                         data-percent="{{get_percent($book_count ?? '1' , $book_content_count )}}">
                        <span class="pie-widget-count-3 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل هشدارهای دریافتی یک ساعت اخیر: <span id="alerts_last_hour"
                                class="red">{{$alerts_last_hour  ?? '0'}}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 col-lg-3">
                <div class="pie-widget">
                    <div id="pie-widget-4" class="chart-pie-widget"
                         data-percent="{{get_percent($app_install , $user_count )}}">
                        <span class="pie-widget-count-4 pie-widget-count"></span>
                    </div>
                    <div style="margin-right: 30px ;margin-top: 20px;">
                        <p class="tar"> تعداد کل هشدارهای دریافتی: <span id="alerts_total" class="red">{{$alerts_total  ?? '0'}}</span></p>
                    </div>


                </div>
            </div>

        </div>
    </div>


    <br>
    <br>

    <div class="col-md-12">
        <!-- responsive table example -->
        <p>آخرین هشدار های دریافتی - <a href="/admin/mqtt_alerts">مشاهده تمام هشدار ها</a></p>
        <div class="pmd-card pmd-z-depth pmd-card-custom-view">
            <table id="alerts_table" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0"
                   width="100%">
                <thead>
                <tr>
                    <th>شناسه</th>
                    <th class="tac">شناسه سنسور</th>
                    <th class="tac">شناسه یکتا</th>
                    <th class="tac">پیام هشدار</th>
                    <th class="tac">نمایش کامل</th>
                    <th class="tac">تاپیک</th>
                </tr>
                </thead>

                <tbody>
                <?
                if (isset($alerts) && $alerts != null){
                foreach ($alerts as $alert){
                    ?>
                <tr class="cat_row">
                    <td>{{$alert['id']}}</td>
                    <td class="tac">{{$alert['sensor_id']}}</td>
                    <td class="tac mono_font">{{$alert['sensor_uuid']}}</td>
                    <td class=" red">{{$alert['alert_info']}}</td>
                    <td class="tac">-</td>
                    <td class="tac">{{$alert['topic']}}</td>
                </tr>
                <? }
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12">
        <!-- responsive table example -->
        <p>آخرین پیام های دریافتی - <a href="/admin/mqtt_messages">مشاهده تمام پیام های دریافتی</a></p>

        <div class="pmd-card pmd-z-depth pmd-card-custom-view">
            <table id="mqtt_messages_table" class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0"
                   width="100%">
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
                if (isset($mqtt_messages) && $mqtt_messages != null){
                foreach ($mqtt_messages as $mqtt_message){
                    ?>
                <tr class="cat_row">
                    <td>{{$mqtt_message['id']}}</td>
                    <td class="tac">{{$mqtt_message['topic']}}</td>
                    <td class="tac">{{$mqtt_message['device_id']}}</td>
                    <td class="tac">{{$mqtt_message['sensor_id']}}</td>
                    <td class="tac">-</td>

                    <td class="tal mono_font">{{$mqtt_message['received_data']}}</td>
                    <td class="tac">{{$mqtt_message['sent_data']}}</td>
                </tr>
                <? }
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function fetchDataAndUpdateSpans() {
                $.ajax("/admin/index/get_last_update", {
                    type: 'get',          // Assuming you want to get data from the server
                    dataType: 'json',      // Expecting JSON data in response
                    success: function (data) {
                        $('#messages_total').text(data.messages_total);  // Update the span with ID "span2"
                        $('#messages_last_hour').text(data.messages_last_hour);  // Update the span with ID "span2"
                        $('#alerts_total').text(data.alerts_total);  // Update the span with ID "span1"
                        $('#alerts_last_hour').text(data.alerts_last_hour);  // Update the span with ID "span1"

                        // Update the alerts table
                        var alertsHtml = '';
                        data.alerts.forEach(function(alert) {
                            alertsHtml += '<tr>' +
                                '<td>' + alert.id + '</td>' +
                                '<td class="tac">' + alert.sensor_id + '</td>' +
                                '<td class="tac mono_font">' + alert.sensor_uuid + '</td>' +
                                '<td class="red">' + alert.alert_info + '</td>' +
                                '<td class="tac">-</td>' +
                                '<td class="tac">' + alert.topic + '</td>' +
                                '</tr>';
                        });
                        $('#alerts_table tbody').html(alertsHtml);

                        var mqttMessagesHtml = '';
                        data.mqtt_messages.forEach(function(message) {
                            mqttMessagesHtml += '<tr>' +
                                '<td>' + message.id + '</td>' +
                                '<td class="tac">' + message.topic + '</td>' +
                                '<td class="tac">' + (message.device_id ? message.device_id : '') + '</td>' +                                 '<td class="tac">' + message.sensor_id + '</td>' +
                                '<td class="tac">-</td>' +
                                '<td class="tal mono_font">' + message.received_data + '</td>' +
                                '<td class="tac">' +  '</td>' +
                                '</tr>';
                        });
                        $('#mqtt_messages_table tbody').html(mqttMessagesHtml);

                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        console.log("Error occurred while fetching data:", error);
                    }
                });
            }

            // Call fetchDataAndUpdateSpans every 2 seconds
            setInterval(fetchDataAndUpdateSpans, 1000);
        });

    </script>

@endsection
