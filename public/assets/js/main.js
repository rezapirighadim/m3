

function validateEmail(element){
    var email=element.val();
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!regex.test(email)){
        element.removeClass("correct");
        element.addClass("wrong");
        return;
    }

    $.ajax({
        type:'POST',
        url:'/user/isEmailRegisterd',
        dataType:'json',
        data:{
            email:email
        }
    }).done(function(data){
            if(data.isFree){
                element.removeClass("wrong");
                element.addClass("correct");
            }else{
                element.removeClass("correct");
                element.addClass("wrong");
            }
        }
    );
}
//****************************************

function isPasswordValid(){
    var element1 =$("#password1");
    var element2 =$("#password2");
    var hiddenElement=$("#password");

    var mustReturn=false;
    if(element1.val().length<4){
        element1.removeClass("correct");
        element1.addClass("wrong");
        mustReturn=true;
    }
    if(element2.val().length<4){
        element2.removeClass("correct");
        element2.addClass("wrong");
        mustReturn=true;

    }
    if(mustReturn){
        return;
    }
    if (element1.val() !== element2.val()){
        element1.removeClass("correct");
        element1.addClass("wrong");
        element2.removeClass("correct");
        element2.addClass("wrong");
    }else{
        element1.removeClass("wrong");
        element1.addClass("correct");
        element2.removeClass("wrong");
        element2.addClass("correct");
        hiddenElement.val(hex_sha1(hex_md5(element1.val())));

    }
}
//****************************************
    function isFreeUsername(element){
        if(element.val().length<4){
            element.removeClass("correct");
            element.addClass("wrong");

            return;
        }

        $.ajax({
            type:'POST',
            url:'/user/isFreeUsername',
            dataType:'json',
            data:{
                username:element.val()
            }
        }).done(function(data){
                if(data.isFree){
                    element.removeClass("wrong");
                    element.addClass("correct");
                }else{
                    element.removeClass("correct");
                    element.addClass("wrong");
                }
            }
        );
    }

//****************************************



    function validateInput(element){
        var rule = element.data('rule');

        if (rule==undefined){
            return;
        }

        if (rule=="email"){
            validateEmail(element);
        }
        if (rule=="password"){
            isPasswordValid();
        }

        if (rule=="username"){
            isFreeUsername(element);
        }
    }
    $(function(){

        $("input").each(function(){
            validateInput($(this));
            $(this).on('keyup',function(){
                validateInput($(this));
            });
        });
    });


function checkChar(e,type,AllowSpace) {
    var keycode;
    if (window.event)  keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    if (keycode  == 0 || keycode == 8 || keycode == 9 || keycode == 13 || keycode==44 || (AllowSpace !=  undefined && keycode == 32))
        return  true;
    switch (type)
    {
        case 1: if (keycode < 48 ||  keycode > 57){
            alert('Only  0-9');
            return false;  // Only Number
        }
            break;
        case 2: if ((keycode < 48 ||  keycode > 57) && (keycode < 1570 ||  keycode > 1740)){
            alert('لطفا فقط فارسی تایپ کنید');
            return false;  // Only Persian
        }
            break;
        case 3: if (keycode < 48 ||  (keycode > 90 && keycode < 97) || keycode > 122){
            alert('Only  0-9  and  A-Z');
            return false; // Only English
        }
            break;
    }
    return true;

//how to use
// <input type="text" name="username" onkeypress="return  checkChar(event,3,1);" />
}



function digitGrouping( num ) {
    num.toString().replace( /\B(?=(?:\d{3})+)$/g, "," );
}












//data table

var exampleDatatable = $('#example').DataTable({
    pageLength: 25,

    responsive: {
        details: {
            type: 'column',
            target: 'tr'

        }
    },
    columnDefs: [ {
        className: 'control',
        orderable: false,
        targets:  -2
    } ],
    order: [ 0, 'desc' ],
    bFilter: true,
    bLengthChange: true,
    pagingType: "full_numbers",
    "fnDrawCallback": function(){
        console.log("fnDrawCallback");
    },
    "paging": true,
    "searching": true,
    "language": {
        "info": " _START_ تا _END_ از _TOTAL_ ردیف ",
        "sLengthMenu": "<span class='custom-select-title'>تعداد ردیف در صفحه :</span> <span class='custom-select'> _MENU_ </span>",
        "sSearch": "",
        "sSearchPlaceholder": "جستجو",
        "paginate": {
            "sNext": " ",
            "sPrevious": " ",
            "sLast": " آخر ",
            "sFirst": " اول ",
            "sInfoFiltered":  " فیلتر شده از _MAX_ ردیف"

        },
    },
    dom:
    "<'pmd-card-title'<'data-table-responsive pull-left'><'search-paper pmd-textfield'f>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",
});

// to safhe haye dovom va be bad popup kar nemikard ba in kar dorost shod
$('#example').on('click', '.popoverBox', function () {
    $(".tooltipLink").tooltip({
        animation: true
    });
    $(".popoverBox").popover({
        animation: true
    });

} );




/// Select value
$('.custom-select-info').hide();




// on load do these codes

// var a = $("body");
// a.removeClass("black-color");
// a.removeClass("blue-color");
// a.removeClass("deep-blue-color");
// a.removeClass("red-color");
// a.removeClass("light-green-color");
// a.removeClass("default");
// a.addClass("blue-color");