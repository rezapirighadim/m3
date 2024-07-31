<div class="tab-pane fade" id="price">
    <div class="container-fluid" >

        <div class="col-md-12">

            <div class="row">
                <div class="form-group col-md-6">
                    <label>قیمت کتاب فیزیکی (قبل از تخفیف)</label>
                    <input type="text" class="form-control number" name="show_price" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $reqBook['show_price'] : "")?>" placeholder="عدد به ریال">

                </div>

                <div class="form-group col-md-6">
                    <label>قیمت کتاب الکترونیکی (قبل از تخفیف)</label>
                    <input type="text" class="form-control number" name="show_price_in_app" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $reqBook['show_price_in_app'] : "")?>" placeholder="عدد به ریال">
                </div>

                <div class="form-group col-md-6">
                    <label>قیمت نهایی کتاب فیزیکی (اصلی)</label>
                    <input type="text" class="form-control number" name="price" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $reqBook['price'] : "")?>" placeholder="عدد به ریال">
                </div>

                <div class="form-group col-md-6">
                    <label>قیمت نهایی کتاب الکترونیکی (اصلی)</label>
                    <input type="text" class="form-control number" name="price_in_app" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $reqBook['price_in_app'] : "")?>" placeholder="اگر کتاب رایگان است خالی بماند.">
                </div>



                <div class="form-group col-md-6">
                    <label>تعداد کتب موجود در انبار</label>
                    <input type="text" class="form-control number" name="count" onclick="format(this)" onkeyup="format(this)"  value="<?=($ready ? $reqBook['count'] : "")?>" placeholder="عدد">
                </div>

            </div>


            <div class="row">
                <div class="col-md-6">
                    <label class="checkbox">
                        <input   <?=($ready && $reqBook['saleable'] == 1 ? "checked":"")?> <?=(!$ready ? "checked" : "")?> name="saleable"  class="icheck-square-green " type="checkbox"  id="checkRed6" >
                        <span> قابلیت فروش فیزیکی </span>
                    </label>
                </div>

                <div class="col-md-6">
                    <label class="checkbox">
                        <input  <?=($ready && $reqBook['downloadable'] == 1 ? "checked":"")?>   class="icheck-purple" name="downloadable" type="checkbox" id="checkRed5" >
                        <span>قابلیت فروش الکترونیکی</span>
                    </label>
                </div>
            </div>


        </div>

    </div>
</div>
