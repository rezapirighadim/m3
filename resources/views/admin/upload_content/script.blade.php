<script charset="utf-8">
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });


    function swal_alert(messege, type) {
        Swal.fire({"title":messege,"text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":type,"position":"center"});

    }



    $(document).ready(function() {
        var book_id = $("#eddit").val();

        var L = $('#list_options').val()
        if (L) {
            fill_options(JSON.parse(L));
        }

        $("#import_content_browse").fileinput({
            uploadUrl : "/admin/upload_book_content" ,
            // browseOnZoneClick: true,
            showCaption: false,
            browseClass: "btn btn-ls",
            uploadClass: "btn btn-success btn",
            maxFileCount: 1,
            uploadExtraData:{'_token':$('#csrf_token').val() , 'book_id' : $("#book_id").val() },
            showUpload: true,
            browseLabel :  'انتخاب فایل zip' ,
            removeLabel :  'حذف' ,
            cancelLabel :  'لغو ' ,
            uploadLabel :  'آپلود فایل zip محتوا' ,
            dropZoneTitle : 'فایل zip خود را کشیده و  اینجا رها کنید ' ,
            showDrag : false,
            overwriteInitial: true,
            allowedFileExtensions: ["zip" , 'ZIP'],
            theme: 'fas',
            textEncoding : 'utf-8',
            // showAjaxErrorDetails : false,

        });


        $("#import_content_browse").on("filepredelete", function(jqXHR) {
            var abort = true;
            if (confirm("آیا از حذف تصویر جلد مطمعن هستید ؟")) {
                abort = false;
            }
            return abort;
        });


        $('#import_content_browse').on('fileuploaderror', function(event, data, msg) {
            console.log('upload failed', data.previewId, data.index, data.fileId, msg);
            console.log(data);
            console.log(msg);
        });

        $('#import_content_browse').on('fileuploaded', function(event, data, previewId, index) {
            var form = data.form, files = data.files, extra = data.extra,
                response = data.response, reader = data.reader;
            console.log('File uploaded triggered');
            console.log(response);
            if (response.uploaded == 'success'){
                var list  = response.heading_row;


                // fill_options(list)
                swal_alert('فایل با موفقیت آپلود شد . برای ادامه لطفا همه فیلد ها را پر کنید.' , 'success')
                // $('#list_options').val(JSON.stringify(list))
                // $('#file_name').val(response.file_name);
                // $('#select_column').css('display' , 'block')
                // $('#upload_xls_zone').css('display' , 'none')

            }
            console.log(reader);
        });
        

        // disable enter btn
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


    });

</script>

