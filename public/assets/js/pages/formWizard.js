jQuery(document).ready(function(a) {
    form_wizard_call();
});

function form_wizard_call() {
    $("#wizard").smartWizard({
        selected: 0,
        keyNavigation: false,
        enableAllSteps: false,
        contentURL: "/profile/loadContent/1",
        transitionEffect: "fade",
        contentURLData: null,
        contentCache: true,
        cycleSteps: false,
        enableFinishButton: false,
        hideButtonsOnDisabled: false,
        errorSteps: [],
        labelNext: "مرحله بعدی",
        labelPrevious: "مرحله قبلی",
        labelFinish:"پایان",
        noForwardJumping: true, // if click in perv steps then disable all after step
        ajaxType: "POST",
        onLeaveStep: null,
        onShowStep: null,
        onFinish: null,
        includeFinishButton: false
    })
}
