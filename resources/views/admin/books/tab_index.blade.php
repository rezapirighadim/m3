<div class="tab-pane fade active show in" id="home">

    <div class="container-fluid" >
        <p class="alert alert-info">در صورتی که تاریخ نشر کتاب از تاریخ فعلی بیشتر باشد در لیست کتاب های بزودی در اپلیکیشن نمایش داده خواهد شد.</p>

        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success btn-block" style="height: 35px;"><?=($ready ? 'ویرایش کتاب' : ' ثبت کتاب ')?></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <a href="/admin/books_list"  class="btn btn-sm btn-warning btn-block" style="height: 35px;padding-top: 8px">برگشت به لیست کتاب ها</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>نام کتاب</label>
                <input id="title" type="name" name="title"  value="<?=($ready ? $reqBook['title'] : "")?>" class="form-control" placeholder="عنوان محصول خود را وارد کنید .">
            </div>
            <p style="background-color: #FAFAFA !important; border: none !important;">  توضیحات مربوط به کتاب را وارد کنید </p>
            <div class="panel panel-default">
                <div class="panel-body no-padding">
                    <textarea name="description" id="book_content_editor"  ><?=($ready ? $reqBook['description'] : "")?></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <h3 class="panel-title">اطلاعات کتاب</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>تعداد صفحه</label>
                            <input type="text" class="form-control number" name="page_number"  value="<?=($ready ? $reqBook['page_number'] : "")?>" placeholder="عدد">
                        </div>

                        <div class="form-group col-md-6">
                            <label>زبان کتاب</label>
                            <input type="text" class="form-control" name="lang"  value="<?=($ready ? $reqBook['lang'] : "")?>" placeholder="فارسی یا انگلیسی">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>محل نشر</label>
                            <input type="text" class="form-control" name="publish_place"  value="<?=($ready ? $reqBook['publish_place'] : "")?>" placeholder="تهران-تهران">
                        </div>

                        <div class="form-group col-md-6">
                            <label>تاریخ نشر</label>
                            <input type="text" class="form-control" name="publish_date"  value="<?=($ready && $reqBook['publish_date'] ? jdate('Y-m-d' , $reqBook['publish_date'] ) : "")?>" placeholder="فرمت صحیح : 20-05-1398">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>کد دویی</label>
                            <input type="text" class="form-control" name="dewey"  value="<?=($ready ? $reqBook['dewey'] : "")?>" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label>شابک (ISBN)</label>
                            <input type="text" class="form-control ltr_input" name="isbn" value="<?=($ready ? $reqBook['isbn'] : "")?>" placeholder="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>قطع کتاب</label>
                            <input type="text" class="form-control" name="cut"  value="<?=($ready ? $reqBook['cut'] : "")?>" placeholder="">
                        </div>
                        <div class="form-group col-md-6">
                            <label>بارکد کتاب</label>
                            <input type="text" class="form-control ltr_input" name="bar_code" value="<?=($ready ? $reqBook['bar_code'] : "")?>" placeholder="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>وزن کتاب (گرم)</label>
                            <input type="text" class="form-control ltr_input" name="weight"  value="<?=($ready ? $reqBook['weight'] : "")?>" placeholder="گرم">
                        </div>
                        <div class="form-group col-md-6">
                            <label>تعداد چاپ</label>
                            <input type="text" class="form-control ltr_input" name="print_count" value="<?=($ready ? $reqBook['print_count'] : "")?>" placeholder="">
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>تیراژ</label>
                            <input type="text" class="form-control ltr_input" name="circulation"  value="<?=($ready ? $reqBook['circulation'] : "")?>" placeholder="">
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
