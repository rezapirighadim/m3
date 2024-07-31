<div class="tab-pane fade " id="pod">

    <div class="container-fluid">
        @if(!$ready)
            <p class="alert alert-warning">امکان ثبت POD بعد از ثبت اطلاعات کتاب ممکن است . بعد از ثبت کتاب در صفحه ویرایش کتاب این قسمت فعال خواهد  شد</p>
        @else
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h3 class="panel-title">اطلاعات کتاب</h3>
                    </div>
                    <div class="panel-body">
                        <br>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label>قطع کتاب</label>
                                    <select id="select_user_5"  onchange="filter_options(this)"  class="demo-default" placeholder="جستجو و انتخاب نوع کاغذ">

                                        <option value="">انتخاب کنید (الزامی) </option>
                                        <option value="RAHLI">رحلی</option>
                                        <option value="VAZIRI">وزیری</option>
                                        <option value="NIMVAZIRI">نیم وزیری</option>
                                        <option value="ROGHEI">رقعی</option>
                                        <option value="NIMROGHEI">نیم رقعی</option>
                                        <?if($ready) {
                                            echo "<script> $(function(){ $('#select_user_5').val('" . $pod_data['cut'] ."') ;}); </script>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>تعداد صفحات مشکی</label>
                                <input type="text" class="form-control number" name="black_pages_count"  value="<?=($ready ? $pod_data['black_pages_count']   : '0')?>" placeholder="عدد به لاتین">
                            </div>

                            <div class="form-group col-md-6">
                                <label>تعداد صفحات رنگی</label>
                                <input type="text" class="form-control" name="colored_pages_count"  value="<?=($ready ? $pod_data['colored_pages_count'] : '0')?>" placeholder="عدد به لاتین">
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>تعداد صفحات کاغذ تحریر</label>
                                <input type="text" class="form-control number" name="POD_PP_TAHRIR"  value="<?=($ready ? $pod_data['POD_PP_TAHRIR']   : '0')?>" placeholder="عدد به لاتین">
                            </div>

                            <div class="form-group col-md-4">
                                <label>تعداد صفحات کاغذ بالک</label>
                                <input type="text" class="form-control number" name="POD_PP_BALK"  value="<?=($ready ? $pod_data['POD_PP_BALK']   : '0')?>" placeholder="عدد به لاتین">
                            </div>

                            <div class="form-group col-md-4">
                                <label>تعداد صفحات کاغذ گلاسه</label>
                                <input type="text" class="form-control number" name="POD_PP_GELASE"  value="<?=($ready ? $pod_data['POD_PP_GELASE']   : '0')?>" placeholder="عدد به لاتین">
                            </div>

                        </div>
                        <br>




                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>نوع صحافی جلد</label>
                                <select id="select_user_3" name="cover_type" multiple  class="demo-default" placeholder="جستجو و انتخاب نوع جلد">
                                    <?foreach ($cover_types as $key => $value){?>
                                    <option value="<?=$key?>"><?=$value?></option>
                                    <?}
                                    if($ready) {
                                        echo "<script> $(function(){ $('#select_user_3').val('" . $pod_data['cover_type'] ."') ; }); </script>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>ضریب سود</label>
                                <select id="select_user_6" name="profitـcoefficient"  class="demo-default" placeholder="جستجو و انتخاب ضریب سود">
                                    <option value="1"> x 1 </option>
                                    <option value="2"> x 2 </option>
                                    <option value="3"> x 3 </option>
                                    <option value="4"> x 4 </option>
                                    <option value="5"> x 5 </option>
                                    <option value="6"> x 6 </option>
                                    <option value="7"> x 7 </option>
                                    <option value="8"> x 8 </option>
                                    <option value="9"> x 9 </option>
                                    <option value="10"> x 10 </option>
                                    <?if($ready) {
                                        echo "<script> $(function(){ $('#select_user_6').val(" . $pod_data['profitـcoefficient'] ." ) ;}); </script>";
                                    }
                                    ?>
                                </select>
                            </div>





                        </div>

                    </div>

                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">محاسبات و ثبت اطلاعات POD</h3>
                    </div>
                    <div class="panel-body" style="width: 100% ; height: 100%">
                        <div id="loader" style="display:none;position: absolute;z-index: 10; background-color: rgba(123,123,123,.4) ; right: 15px;left: 15px;top: 37px;bottom: 20px">
                            <i style="position: absolute;top: 40%;left: 47%;" class="fa fa-3x fa-spin fa-spinner"></i>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="btn btn-primary" id="calculate_pod" onclick="calculate_pod(this , false)" >نمایش محاسبات</p>
                                <p class="btn btn-success" id="calculate_pod" onclick="save_update_pdo(this)" > ثبت  POD </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table  class="table pmd-table table-hover table-striped  display responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>-</th>
                                        <th>قیمت واحد</th>
                                        <th>تعداد صفحه</th>
                                        <th>جمع کل</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr class="cat_row">
                                        <td>هزینه کاغذ تحریر :</td>
                                        <td id="POD_PP_TAHRIR">-</td>  <td id="POD_PP_TAHRIR_count">-</td>  <td id="POD_PP_TAHRIR_total">-</td>
                                    </tr>
                                    <tr class="cat_row">
                                        <td> هزینه کاغذ بالک :</td>
                                        <td id="POD_PP_BALK">-</td>  <td id="POD_PP_BALK_count">-</td>  <td id="POD_PP_BALK_total">-</td>
                                    </tr>
                                    <tr class="cat_row">
                                        <td> هزینه کاغذ گلاسه :</td>
                                        <td id="POD_PP_GELASE">-</td>  <td id="POD_PP_GELASE_count">-</td>  <td id="POD_PP_GELASE_total">-</td>
                                    </tr>
                                    <tr class="cat_row">
                                        <td> هزینه صحافی جلد :</td>
                                        <td id="cover_price">-</td>  <td id="cover_price_count">-</td>  <td id="cover_price_total">-</td>
                                    </tr>
                                    <tr class="cat_row">
                                        <td> هزینه چاپ هر صفحه مشکی :</td>
                                        <td id="POD_CHAP_MESHKI" >-</td>  <td id="POD_CHAP_MESHKI_count" >-</td>  <td id="POD_CHAP_MESHKI_total">-</td>
                                    </tr>
                                    <tr class="cat_row">
                                        <td>هزینه چاپ هر صفحه رنگی :</td>
                                        <td id="POD_CHAP_COLOR">-</td>  <td id="POD_CHAP_COLOR_count">-</td>  <td id="POD_CHAP_COLOR_total">-</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <hr>
                                <p class="hoverP"> <span class="info-label"> هزینه چاپ این کتاب :</span> <span id="book_price" class="info-body"> - </span> </p>
                                <p class="hoverP2"> <span class="info-label-2"> قیمت فروش کتاب:</span> <span id="book_price_for_user" class="info-body-2"> - </span> </p>

                            </div>
                        </div>
                    </div>

                </div>


            </div>


            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">بارگذاری فایل و تصویر جلد کتاب</h3>
                    </div>
                    <div class="panel-body" style="width: 100% ; height: 100%">
                        <div class="form-group col-md-12">
                            <div class="col-md-12 ls-group-input">
                                <input name="pod_image" id="pod_image_browse" type="file" multiple>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <div class="col-md-12 ls-group-input">
                                <input name="pod_file" id="pod_book_file_brows" type="file" multiple>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        @endif

    </div>
</div>
