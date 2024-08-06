@extends("admin.theme.main")
@section('content')

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
                            if(isset($records) && $records!=null){
                            foreach($records as $record){?>
                            <tr class="cat_row">
                                <td>{{$record['id']}}</td>
                                <td class="tac">{{$record['topic']}}</td>
                                <td class="tac">{{$record['device_id']}}</td>
                                <td class="tac">{{$record['sensor_id']}}</td>
                                <td class="tac">-</td>

                                <td class="tac">{{$record['received_data']}}</td>
                                <td class="tac">{{$record['sent_data']}}</td>
                            </tr>
                            <?}}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </section>



        </div>
    </div>
    <script>

    </script>
@endsection
