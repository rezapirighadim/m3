<div class="tab-pane fade" id="extra_data">
    <div class="container-fluid" >

        <div class="col-md-12">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label> انتخاب دسته بندی در اپ شما </label>
                        <select id="select_user" name="category_id" multiple  class="demo-default" placeholder="جستجو و انتخاب دسته بندی">
                            <?foreach ($categories as $record){?>
                            <option value="<?=$record['id']?>"><?=$record->getParentsNames()?></option>
                            <?}
                            if($ready) {
                                echo "<script> $(function(){ $('#select_user').val(" . $reqBook['category_id'] ." ) ;}); </script>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label> انتخاب دسته بندی در اپ عمومی </label>
                        <select id="select_user_1" name="admin_category_id" multiple  class="demo-default" placeholder="جستجو و انتخاب دسته بندی">
                            <?foreach ($admin_categories as $record){?>
                            <option value="<?=$record['id']?>"><?=$record->getParentsNames()?></option>
                            <?}
                            if($ready) {
                                echo "<script> $(function(){ $('#select_user_1').val(" . $reqBook['admin_category_id'] ." ) ;}); </script>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <p class="guild_p">
                    <span class="add_btn" onclick="add_creator(this)"> + </span>
                    اضافه کردن نویسندگان - مترجمان و ...
                </p>
                <hr>

                <div class="row col-md-12" id="book_creator">
                    @if ($ready && $reqBook['creators'])
                        @foreach($reqBook['creators'] as $key => $value)
                            <div class="creators">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control " name="creators[{{$key}}][type]" value="{{$value['type']}}" placeholder="عنوان" id="long">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control " name="creators[{{$key}}][name]" value="{{$value['name']}}" placeholder="نام و نام خانوادگی" id="long">
                                    </div>
                                </div>
                                <div class="col-md-2" >
                                    <span class="delete_btn" onclick="remove_creator(this)"> X </span>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <div class="row">
                <p class="guild_p">اضافه کردن تگ ها (موضوعات)</p>
                <hr>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>تگ ها</label>
                        <input type="text" class="form-control " name="tags" value="<?=($ready ? $reqBook['tags'] : "")?>" placeholder="با - از هم جدا شود . مثل :‌ مذهبی-رمان" id="long">
                    </div>
                </div>
            </div>
            <div class="row">
                <p class="guild_p">اضافه کردن ناشر (ناشران)</p>
                <hr>


                <div class="col-md-12">
                    <div class="form-group">
                        <label> انتخاب ناشر (‌ناشران) </label>
                        <select id="select-state" name="publishers[]" multiple  class="demo-default" placeholder="جستجو و انتخاب ناشران">
                            <?foreach ($publishers as $record){?>
                            <option value="{{$record['title']}}" {{$ready && in_array($record['title'] , $reqBook['publishers'])  ? 'selected' : ''}}>{{$record['title']}}</option>
                            <?}
                            if($ready) {
//                                                            echo "<script> $(function(){ $('#select-state').val(" . $reqBook['title'] ." ) ;}); </script>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
