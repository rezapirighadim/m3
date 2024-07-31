jQuery(document).ready(function(a) {
        select_country_call();
        select_one_element_call();
        select_state_call();
        select_user_call();
        // select_state_disabled_call();
        // input_sortable_call();
        // input_tags_call();
        // demo_code_language_call();
        // select_repeated_options_call();
        // select_to_call()
    }

);
var eventHandler=function(a) {
        return function() {}
    }

    ;
function select_country_call() {
    var a=$("#select-country").selectize( {
            create: false, onChange: eventHandler("onChange"), onItemAdd: eventHandler("onItemAdd"), onItemRemove: eventHandler("onItemRemove"), onOptionAdd: eventHandler("onOptionAdd"), onOptionRemove: eventHandler("onOptionRemove"), onDropdownOpen: eventHandler("onDropdownOpen"), onDropdownClose: eventHandler("onDropdownClose"), onInitialize: eventHandler("onInitialize")
        }
    )
}
function select_one_element_call() {
    var a=$("#select_one_element").selectize( {
            create: false, onChange: eventHandler("onChange"), onItemAdd: eventHandler("onItemAdd"), onItemRemove: eventHandler("onItemRemove"), onOptionAdd: eventHandler("onOptionAdd"), onOptionRemove: eventHandler("onOptionRemove"), onDropdownOpen: eventHandler("onDropdownOpen"), onDropdownClose: eventHandler("onDropdownClose"), onInitialize: eventHandler("onInitialize")
        }
    )
}

function select_state_call() {
    $("#select-state").selectize( {
            maxItems: 200, create: false
        }
    )
}
function select_user_call() {
    $("#select_user").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_1").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_2").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_3").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_4").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_5").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_6").selectize( {
            maxItems: 1, create: false
        }
    );
    $("#select_user_7").selectize( {
            maxItems: 1, create: false
        }
    );
}

function select_state_disabled_call() {
    $("#select-state-disabled").selectize( {
            maxItems: 3
        }
    )
}

function input_sortable_call() {
    $(".input-sortable").selectize( {
            plugins: ["drag_drop"], persist: false, create: true
        }
    )
}

function input_tags_call() {
    $(".input-tags").selectize( {
            plugins:["remove_button"], delimiter:",", persist:false, create:function(a) {
                return {
                    value: a, text: a
                }
            }
            , render: {
                item:function(b, a) {
                    return'<div>"'+a(b.text)+'"</div>'
                }
            }
            , onDelete:function(a) {
                return confirm(a.length>1?"Are you sure you want to remove these "+a.length+" items?": 'Are you sure you want to remove "'+a[0]+'"?')
            }
        }
    )
}

function demo_code_language_call() {
    $(".demo-code-language").selectize( {
            sortField:"text", hideSelected:false, plugins: {
                dropdown_header: {
                    title: "Language"
                }
            }
        }
    )
}

function select_repeated_options_call() {
    $("#select-repeated-options").selectize( {
            sortField: "text"
        }
    )
}

var REGEX_EMAIL="([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
var formatName=function(a) {
        return $.trim((a.first_name||"")+" "+(a.last_name||""))
    }

    ;
function select_to_call() {
    $("#select-to").selectize( {
            persist:false, maxItems:null, valueField:"email", labelField:"name", searchField:["first_name", "last_name", "email"], sortField:[ {
                field: "first_name", direction: "asc"
            }
                , {
                    field: "last_name", direction: "asc"
                }
            ], options:[ {
                email: "jone.doe1@mail.com", first_name: "Jone", last_name: "Doe 1"
            }
                , {
                    email: "jone.doe2@mail.com", first_name: "Jone", last_name: "Doe 2"
                }
                , {
                    email: "jone.doe3@mail.com", first_name: "Jone", last_name: "Doe 3"
                }
                , {
                    email: "jone.doe4@mail.com", first_name: "Jone", last_name: "Doe 4"
                }
                , {
                    email: "jone.doe5@mail.com", first_name: "Jone", last_name: "Doe 5"
                }
                , {
                    email: "jone.doe6@mail.com", first_name: "Jone", last_name: "Doe 6"
                }
                , {
                    email: "jone.doe7@mail.com", first_name: "Jone", last_name: "Doe 7"
                }
                , {
                    email: "jone.doe8@mail.com", first_name: "Jone", last_name: "Doe 8"
                }
                , {
                    email: "jone.doe9@mail.com", first_name: "Jone", last_name: "Doe 9"
                }
                , ], render: {
                item:function(c, b) {
                    var a=formatName(c);
                    return"<div>"+(a?'<span class="name">'+b(a)+"</span>, ": "")+(c.email?'<span class="email">'+b(c.email)+"</span>": "")+"</div>"
                }
                , option:function(e, d) {
                    var c=formatName(e);
                    var b=c||e.email;
                    var a=c?e.email: null;
                    return'<div><span class="label">'+d(b)+"</span>"+(a?'<span class="caption">'+d(a)+"</span>": "")+"</div>"
                }
            }
            , create:function(b) {
                if((new RegExp("^"+REGEX_EMAIL+"$", "i")).test(b)) {
                    return {
                        email: b
                    }
                }
                var d=b.match(new RegExp("^([^<]*)<"+REGEX_EMAIL+">$", "i"));
                if(d) {
                    var c=$.trim(d[1]);
                    var f=c.indexOf(" ");
                    var e=c.substring(0, f);
                    var a=c.substring(f+1);
                    return {
                        email: d[2], first_name: e, last_name: a
                    }
                }
                alert("Invalid email address.");
                return false
            }
        }
    )
}

;