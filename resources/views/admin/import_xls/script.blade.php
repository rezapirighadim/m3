<script charset="utf-8">
    // $.ajaxSetup({
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    // });


    function swal_alert(messege, type) {
        Swal.fire({"title":messege,"text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":type,"position":"center"});

    }


    function fill_options(options){


        for (var i = 1 ; i <= 5 ; i++ ) {
            var $select = $("#select_user_" + i).selectize([]);
            var selectize2 = $select[0].selectize;
            selectize2.clearOptions();
            $.each(options, function(i, obj) {
                // selectize2.addOption({value: obj, text: obj});
                selectize2.addOption({value: i, text: obj});
            });
            // selectize2.refreshOptions();
        }

    }





    $(document).ready(function() {
        var book_id = $("#eddit").val();

        var L = $('#list_options').val()
        if (L) {
            fill_options(JSON.parse(L));
        }

        $("#import_xls_browse").fileinput({
            uploadUrl : "/admin/import_upload" ,
            // browseOnZoneClick: true,
            showCaption: false,
            browseClass: "btn btn-ls",
            uploadClass: "btn btn-success btn",
            maxFileCount: 1,
            uploadExtraData:{'_token':$('#csrf_token').val()},
            showUpload: true,
            browseLabel :  'انتخاب فایل excel' ,
            removeLabel :  'حذف' ,
            cancelLabel :  'لغو ' ,
            uploadLabel :  'آپلود فایل excel' ,
            dropZoneTitle : 'فایل excel خود را کشیده و  اینجا رها کنید ' ,
            showDrag : false,
            overwriteInitial: true,
            allowedFileExtensions: ["csv"  , 'xlsx', "xls"],
            theme: 'fas',
            textEncoding : 'utf-8',
            // showAjaxErrorDetails : false,

        });
        

        $("#import_xls_browse").on("filepredelete", function(jqXHR) {
            var abort = true;
            if (confirm("آیا از حذف تصویر جلد مطمعن هستید ؟")) {
                abort = false;
            }
            return abort;
        });
       

        $('#import_xls_browse').on('fileuploaderror', function(event, data, msg) {
            console.log('upload failed', data.previewId, data.index, data.fileId, msg);
            console.log(data);
            console.log(msg);
        });

        $('#import_xls_browse').on('fileuploaded', function(event, data, previewId, index) {
            var form = data.form, files = data.files, extra = data.extra,
                response = data.response, reader = data.reader;
            console.log('File uploaded triggered');
            console.log(response);
            if (response.uploaded == 'success'){
                var list  = response.heading_row;


                fill_options(list)
                swal_alert('فایل با موفقیت آپلود شد . برای ادامه لطفا همه فیلد ها را پر کنید.' , 'success')
                $('#list_options').val(JSON.stringify(list))
                $('#file_name').val(response.file_name);
                $('#select_column').css('display' , 'block')
                $('#upload_xls_zone').css('display' , 'none')

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

