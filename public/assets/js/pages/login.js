jQuery(document).ready(function(a) {
    bootstrap_switch_trigger_call();
    forgo_password_view();
    login_view_submit();
    ladda_button_call()
});

function bootstrap_switch_trigger_call() {
    $(".switchCheckBox").bootstrapSwitch()
}

function forgo_password_view() {
    $(".forgot-password, .login-view").click(function() {
        $(".login-form, .forgot-pass-box").slideToggle("slow")
    })
}

function login_view_submit() {
    $("#form-login").submit(function() {
        return false
    })
}

function ladda_button_call() {
    Ladda.bind("button.ladda-button", {
        callback: function(a) {
            var c = 0;
            var b = setInterval(function() {
                c = Math.min(c + Math.random() * 0.1, 1);
                a.setProgress(c);
                if (c === 1) {
                    a.stop();
                    clearInterval(b);
                    var d = humane.create({
                        baseCls: "humane-jackedup",
                        addnCls: "humane-jackedup-success"
                    });
                    d.log("<i class='fa fa-smile-o'></i> با موفقیت وارد سایت شدید ");
                    setInterval(function() {
                        var e = "/admin/home";
                        window.location.assign(e)
                    }, 500)
                }
            }, 200)
        }
    })
};