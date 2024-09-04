@extends('admin.theme.main')
@section('content')
    <?
    $ready = false;
    if (isset($requestedSensors) && $requestedSensors !== null) {
        $ready = true;
        $requestedData = $requestedSensors;
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">فرم ارسال داده</h3>
                </div>
                <div class="panel-body">
                    @php (isset($message) ? "<p class=\"alert alert-success\">$message</p>" : "") @endphp
                    <form class="ls_form" role="form" action="{{ URL::to('admin/send_data') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}

                        <p class="alert alert-info">
                            این بخش به علت ارسال پیام اضطراری و تنظیمات تعبیه شده است و امکان ارسال هر نوع پیامی را به تاپیک های مختلف مقدور می سازد.
                        </p>
                        <input type="hidden" name="edit"  value="<?=($ready ? $requestedData['id'] : "0")?>">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاپیک</label>
                                    <input id="topic" name="topic" class="form-control ltr mono_font" placeholder="Topic">
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <label>پیام</label>
                                    <textarea rows="5"  name="message" class="form-control  ltr mono_font" id="message"  placeholder="Message (Json OR Raw data)"></textarea>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <a onclick="send_data(this)" type="submit" class="btn btn-info btn-block"> ارسال پیام </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function send_data(sender) {
            sender = $(sender);
            var parent = sender.parentsUntil('.cat_row').parent();

            var topic = $('#topic').val().trim();      // Grabbing and trimming the input value
            var message = $('#message').val().trim();  // Grabbing and trimming the textarea value
            if (topic === "" || message === "") {
                // If either field is empty, show an alert or some other feedback to the user
                Swal.fire({
                    "title": "۴۰۳",
                    "text": "وجود مقادیر تاپیک و پیام برای ارسال اجباری میباشد !",
                    "timer": "1500",
                    "heightAuto": true,
                    "padding": "1.25rem",
                    "animation": true,
                    "showConfirmButton": false,
                    "showCloseButton": true,
                    "toast": true,
                    "type": "fail",
                    "position": "center"
                });                return ;
            }

            $.ajax("/admin/send_data", {
                type: 'post',
                dataType: 'json',
                data: {
                    topic: topic,         // Sending the topic value
                    message: message      // Sending the message value
                },
                success: function (data) {
                    console.log("Data sent successfully:", data);
                    Swal.fire({
                        "title": "موفق",
                        "text": "با موفقیت ارسال شد !",
                        "timer": "1500",
                        "heightAuto": true,
                        "padding": "1.25rem",
                        "animation": true,
                        "showConfirmButton": false,
                        "showCloseButton": true,
                        "toast": true,
                        "type": "success",
                        "position": "center"
                    });

                },
                error: function (xhr, status, error) {
                    console.log("Error occurred:", error);
                    Swal.fire({
                        "title": "نا موفق",
                        "text": "ارسال انجام نشد !",
                        "timer": "1500",
                        "heightAuto": true,
                        "padding": "1.25rem",
                        "animation": true,
                        "showConfirmButton": false,
                        "showCloseButton": true,
                        "toast": true,
                        "type": "fail",
                        "position": "center"
                    });
                }
            });
        }

    </script>

@endsection
