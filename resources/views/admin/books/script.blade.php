<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    function save_update_pdo(element){

        calculate_pod(element , true);
    }


    function calculate_pod(element , save_proccess){

        var black_pages_count = $("input[name=black_pages_count]").val();
        var colored_pages_count = $("input[name=colored_pages_count]").val();

        var POD_PP_TAHRIR = $("input[name=POD_PP_TAHRIR]").val();
        var POD_PP_BALK = $("input[name=POD_PP_BALK]").val();
        var POD_PP_GELASE = $("input[name=POD_PP_GELASE]").val();

        var cut = $("#select_user_5").val();

        var cover_type = $("#select_user_3").val();
        var profitـcoefficient = $("#select_user_6").val();
        var book_id = $("#eddit").val();

        if(!black_pages_count) return swal_alert('ثبت تعداد صفحات مشکی الزامیست' , 'error');
        if(!colored_pages_count) return swal_alert('ثبت تعداد صفحات رنگی الزامیست' , 'error');
        if(!POD_PP_TAHRIR) return swal_alert('ثبت تعداد صفحات تحریر الزامیست' , 'error');
        if(!POD_PP_BALK) return swal_alert('ثبت تعداد صفحات بالک الزامیست' , 'error');
        if(!POD_PP_GELASE) return swal_alert('ثبت تعداد صفحات گلاسه الزامیست' , 'error');
        if(!cut) return swal_alert('انتخاب قظع کتاب الزامی میباشد' , 'error');
        if(!cover_type) return swal_alert('انتخاب نوع صحافی جلد الزامی میباشد' , 'error');
        if(!profitـcoefficient) return swal_alert('انتخاب ضریب سود الزامی میباشد' , 'error');
        if(!book_id) return swal_alert('ثبت اطلاعات POD فقط بعد از ثبت کتاب ممکن است ' , 'error');

        var meshki_rangi = parseInt(black_pages_count) + parseInt(colored_pages_count);
        var x_x_x = parseInt(POD_PP_TAHRIR) + parseInt(POD_PP_BALK) + parseInt(POD_PP_GELASE) ;
        if(meshki_rangi != x_x_x) return swal_alert('مجموع صفحات مشکی و رنگی باید با مجموع صفحات تحریر و بالک و گلاسه برابر باشد' , 'error');

        $('#loader').css('display' , 'inline');


        var data = {
            black_pages_count:black_pages_count ,
            colored_pages_count:colored_pages_count ,

            POD_PP_TAHRIR:POD_PP_TAHRIR ,
            POD_PP_BALK:POD_PP_BALK ,
            POD_PP_GELASE:POD_PP_GELASE ,

            cover_type:cover_type[0],
            profitـcoefficient:profitـcoefficient,
            book_id : book_id,
            cut : cut
        };


        $.ajax({
            type:'POST',
            url:'/admin/calculate_pod',
            data:data,
            success:function(data){
                if(!save_proccess) $('#loader').css('display' , 'none')
                fill_calculated_data(data);
            },
            error:function(e){
                if (!save_proccess) $('#loader').css('display' , 'none')
            }
        });


        if(save_proccess){

            $.ajax({
                type:'POST',
                url:'/admin/save_update_pdo',
                data:data,
                success:function(data){
                    $('#loader').css('display' , 'none');
                    swal_alert('اطلاعات با موفقیت ثبت شد.' , 'success');

                },
                error:function(e){
                    $('#loader').css('display' , 'none')
                    swal_alert('مشکلی در ثبت اطلاعات رخ داد . لطفا با برسی دوباره مقادیر ورودی مجددا تلاش کنید.', 'error');

                }
            });

            if($("#pod_image_browse").val()) $('#pod_image_browse').fileinput('upload');
            if($("#pod_book_file_brows").val()) $('#pod_book_file_brows').fileinput('upload');


        }
    }

    function swal_alert(messege, type) {
        Swal.fire({"title":messege,"text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":type,"position":"center"});

    }

    function fill_calculated_data(data) {

        $('#POD_PP_TAHRIR').html(data.POD_PP_TAHRIR.toLocaleString() + ' ریال ');
        $('#POD_PP_TAHRIR_count').html( $("input[name=POD_PP_TAHRIR]").val() );
        $('#POD_PP_TAHRIR_total').html( ($("input[name=POD_PP_TAHRIR]").val() * data.POD_PP_TAHRIR).toLocaleString() + ' ریال ' );

        $('#POD_PP_BALK').html(data.POD_PP_BALK.toLocaleString() + ' ریال ');
        $('#POD_PP_BALK_count').html( $("input[name=POD_PP_BALK]").val() );
        $('#POD_PP_BALK_total').html( ($("input[name=POD_PP_BALK]").val() * data.POD_PP_BALK).toLocaleString() + ' ریال '  );


        $('#POD_PP_GELASE').html(data.POD_PP_GELASE.toLocaleString() + ' ریال ');
        $('#POD_PP_GELASE_count').html( $("input[name=POD_PP_GELASE]").val() );
        $('#POD_PP_GELASE_total').html( ($("input[name=POD_PP_GELASE]").val() * data.POD_PP_GELASE ).toLocaleString() + ' ریال ' );


        $('#POD_CHAP_MESHKI').html(data.POD_CHAP_MESHKI.toLocaleString() + ' ریال ');
        $('#POD_CHAP_MESHKI_count').html( $("input[name=black_pages_count]").val() );
        $('#POD_CHAP_MESHKI_total').html( ($("input[name=black_pages_count]").val() * data.POD_CHAP_MESHKI ).toLocaleString() + ' ریال ' );


        $('#POD_CHAP_COLOR').html(data.POD_CHAP_COLOR.toLocaleString() + ' ریال ');
        $('#POD_CHAP_COLOR_count').html( $("input[name=colored_pages_count]").val() );
        $('#POD_CHAP_COLOR_total').html( ($("input[name=colored_pages_count]").val() * data.POD_CHAP_COLOR ).toLocaleString() + ' ریال ' );


        $('#cover_price').html(data.cover_price.toLocaleString() + ' ریال ');
        $('#cover_price_count').html( 1 );
        $('#cover_price_total').html( (data.cover_price ).toLocaleString() + ' ریال ' );


        $('#book_price').html(data.book_price.toLocaleString() + ' ریال ');
        $('#book_price_for_user').html(data.book_price_for_user.toLocaleString() + ' ریال ');
    }


    function filter_options(element){
        var element = $(element);
        var cover_type = <?=json_encode($cover_types , true)?>;

        var selected = element.val() ;
        if(!selected) return ;
        selected = '_' + selected;


        var $select = $("#select_user_3").selectize([]);
        var selectize2 = $select[0].selectize;
        selectize2.clearOptions();
        $.each(cover_type, function(i, obj) {
            var index = i.indexOf(selected);
            if(index !== -1){
                selectize2.addOption({value: i, text: obj});
            }
        });
        selectize2.refreshOptions();
    }

    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function add_creator() {
        var id = makeid(6);
        $("#book_creator").append("<div class='creators'>" +
            " <div class='col-md-5'>" +
            " <div class='form-group'>" +
            "<input type='text' class='form-control'  name='creators[" + id + "][type]' placeholder='عنوان'>" +
            " </div>" +
            " </div>" +
            "<div class='col-md-5'>" +
            "<div class='form-group'>" +
            "<input type='text' class='form-control' name='creators[" + id + "][name]' placeholder='نام و نام خانوادگی' >" +
            "</div>" +
            "</div>" +
            "<div class='col-md-2' ><span class='delete_btn' onclick='remove_creator(this)'> X </span></div>" +
            "</div>");

    }

    function remove_creator(element) {
        var sender = $(element);
        var parent = sender.parentsUntil('.creators').parent();
        parent.remove();
    }

    function detail_explore(element , id){
        $.ajax("/admin/detail_explore_ajax/" + id, {
            type: 'get',
            dataType: 'json',
            success: function (data) {
                alert(JSON.stringify(data));
                // alert('done');
                $(element).remove();
            }
        });
    }
    function remove_pdf(id) {
        if (confirm("آیا مطمعن هستید؟")) {
            $.ajax("/admin/remove_pdf_file/" + id, {
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    $('#book_none_pdf').removeClass('hidden');
                    // $('.book_pdf_preview').addClass('hidden');
                    $('.book_pdf_preview').remove();
                    Swal.fire({"title":"پیش نمایش با موفقیت حذف شد!","text":"","timer":"1500","width":"1","heightAuto":true,"padding":"1.25rem","animation":true,"showConfirmButton":false,"showCloseButton":true,"toast":true,"type":"success","position":"center"});

                }
            });
        }
    }

    function Func(Shahrestanha) {
        alert(Shahrestanha);
        var _Shahrestan = document.getElementById("Shahrestan");
        _Shahrestan.options.length = 0;
        if(Shahrestanha != "") {
            var arr = Shahrestanha.split(",");
            for(i = 0; i < arr.length; i++) {
                if(arr[i] != "") {
                    _Shahrestan.options[_Shahrestan.options.length]=new Option(arr[i],arr[i]);
                }
            }
        }
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    function format(input){
        return;

        var nStr = input.value + '';
        nStr = nStr.replace( /\,/g, "");
        var x = nStr.split( '.' );
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while ( rgx.test(x1) ) {
            x1 = x1.replace( rgx, '$1' + ',' + '$2' );
        }
        input.value = x1 + x2;
    }





    $(document).ready(function() {
        var book_id = $("#eddit").val();


        var initialPreviewImage = <?=$ready && $pod_data['image'] ? json_encode([env('APP_URL') . '/local/uploads/books/pod/images/' . $pod_data['image']] , true) : json_encode([] , true) ?>;
        var initialPreviewFile =  <?=$ready && $pod_data['file']  ? json_encode([env('APP_URL') . '/local/uploads/books/pod/files/'  . $pod_data['file']]  , true) : json_encode([] , true) ?>;

        $("#pod_image_browse").fileinput({
            uploadUrl : "/admin/upload_pod_file/image/" + book_id,
            deleteUrl: "/admin/delete_pod_file/image/" + book_id,
            // browseOnZoneClick: true,
            showCaption: false,
            browseClass: "btn btn-ls",
            maxFileCount: 1,
            showUpload: false,
            browseLabel :  'انتخاب جلد کتاب' ,
            removeLabel :  'حذف' ,
            dropZoneTitle : 'جلد کتاب را کشیده و اینجا رها کنید ... ' ,
            showDrag : false,
            overwriteInitial: true,
            initialPreview: initialPreviewImage ,
            initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
            // initialPreviewFileType: 'image', // image is the default and can be overridden in config below
            initialPreviewConfig: [
                {caption: "تصویر جلد" },
            ],
            allowedFileExtensions: ["jpg"  , 'jpeg', "png", "gif" , "psd" , "tiff"],
            theme: 'fas',

        });
        $("#pod_book_file_brows").fileinput({
            uploadUrl : "/admin/upload_pod_file/file/" + book_id,
            deleteUrl: "/admin/delete_pod_file/file/" + book_id,
            // browseOnZoneClick: true,
            showCaption: false,
            browseClass: "btn btn-success btn",
            // fileType: "any",
            maxFileCount: 1,
            browseLabel :  'انتخاب فایل کتاب' ,
            removeLabel :  'حذف' ,
            dropZoneTitle : 'فایل کتاب را کشیده و اینجا رها کنید ... ' ,
            overwriteInitial: true,
            initialPreview: initialPreviewFile ,
            initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
            initialPreviewFileType: 'pdf', // image is the default and can be overridden in config below
            initialPreviewConfig: [
                {caption: "فایل کتاب" },
            ],
            allowedFileExtensions: ["pdf"],
            showUpload: false,
            theme: 'fas',
        })

        $("#pod_image_browse").on("filepredelete", function(jqXHR) {
            var abort = true;
            if (confirm("آیا از حذف تصویر جلد مطمعن هستید ؟")) {
                abort = false;
            }
            return abort;
        });
        $("#pod_book_file_brows").on("filepredelete", function(jqXHR) {
            var abort = true;
            if (confirm("آیا از حذف فایل جلد مطمعن هستید ؟")) {
                abort = false;
            }
            return abort;
        });

        $('#pod_image_browse').on('fileuploaderror', function(event, data, msg) {
            console.log('Image uploaded', data.previewId, data.index, data.fileId, msg);
        });
        $('#pod_book_file_brows').on('fileuploaderror', function(event, data, msg) {
            console.log('File uploaded', data.previewId, data.index, data.fileId, msg);
        });


        // disable enter btn
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });



        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        CKEDITOR.replace( 'book_content_editor' );
        CKEDITOR.config.height = 400;


        $('#title').bind('keyup change ', function(){
            var title = $(this).val();
            title = title.replace(/ /gi,'-');
            $('#url_title').val(title);
        });

        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };

        $("#uploadBtn").change(function(){
//            alert("a");
            readURL(this);
        });

        document.getElementById("uploadPdfBtn").onchange = function () {
            document.getElementById("uploadPdfFile").value = this.value;
        };

//             $("#uploadPdfBtn").change(function(){
// //            alert("a");
//                 readURL(this);
//             });


        var cash = $(".number");

        $(cash).keydown(function (e) {
//            alert('aaa');
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    });

</script>

