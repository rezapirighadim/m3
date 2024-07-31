<div class="tab-pane fade" id="preview">
    <div class="container-fluid" >

        <div class="row">
            <div class="col-md-12">

                <div class="fileUpload btn btn-info">
                    <span>انتخاب تصویر محصول</span>
                    <input id="uploadBtn" type="file" name="image" class="upload"  accept="image/jpeg, image/png"/>
                    <input  type="hidden" name="lastImageName" value="<?=($ready ? $reqBook['imageName'] : "")?>" />
                </div>
                <input class="form-control" id="uploadFile" type="text" placeholder="نام عکس انتخاب شده" disabled>

                <div class="fileUpload btn btn-info">
                    <span>انتخاب (تغییر) فایل pdf</span>
                    <input id="uploadPdfBtn" type="file" name="pdfName" class="upload"  accept="application/pdf"/>
                    <input  type="hidden" name="lastPdfName" value="<?=($ready ? $reqBook['pdfName'] : "")?>" />

                </div>
                <input class="form-control" id="uploadPdfFile" type="text" placeholder="نام PDF انتخاب شده" disabled>

                <hr>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div  style="text-align: center">
                    <div style="margin-top:10px ; display: flex; flex-direction: row ; justify-content: space-between">
                        @if ($ready && $reqBook['pdfName'] && check_var($reqBook['pdfName']))
                            <p class="book_pdf_preview "><a target="_blank" href="/local/uploads/books/pdf/{{$reqBook['pdfName']}}">مشاهده پیش نمایش کتاب</a></p>
                            <p class="book_pdf_preview " style="cursor: pointer" onclick="remove_pdf( {{$reqBook['id']}} )"><span class="label label-red">حذف</span></p>
                            <p id="book_none_pdf" class="hidden red">پیش نمایشی برای این کتاب وجود ندارد</p>
                        @else
                            <p class="red">پیش نمایشی برای این کتاب وجود ندارد</p>
                        @endif
                    </div>
                    <hr>
                    <?
                    if ($ready && $reqBook['imageName']){?>
                    <input type="hidden" name="old_image" value="{{$reqBook['imageName']}}">
                    <img style="width: 100% !important;" id="blah" src="{{url('/')}}/local/uploads/books/images/<?=$reqBook['imageName']?>" alt="تصویر انتخاب شده" />
                    <?}else{?>
                    <img style="width: 100% !important;" id="blah" src="#" alt="تصویر محصول را انتخاب کنید" />
                    <?}?>
                </div>
            </div>
        </div>


    </div>
</div>
