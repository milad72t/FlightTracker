setTimeout(fade_out, 5000);

function fade_out() {
    $(".alert-info").fadeOut().empty();
}

$(document).ready(function(){
    $('html, tr').persiaNumber();
});