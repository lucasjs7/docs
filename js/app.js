
function msg(status, text) {

    var blc = $('#msg');

    blc.slideUp(200);

    setTimeout(function(){

        blc.attr('data-type', status);
        blc.find('.content').html(text);
        blc.slideDown(300);

        setTimeout(function(){
            blc.slideUp(200);
        }, 8000);

    }, 200);
}

function closeMsg() {
    $('#msg').slideUp(200);
}

$(document).on('click', '#msg .close', closeMsg);

function loading(status, e, ...h) {

    h.forEach(element => {
        if (status) {
            element.hide();
        } else {
            element.show();
        }
    });

    if (typeof e === 'object') {
        if (status) {
            e.show();
        } else {
            e.hide();
        }
    }
}

$(document).on('click', '.modal', function(e){

    if (e.target === this) {
        $(this).hide();
    }

});

$(document).on('click', '.modal .btn_cancel', function(){

    $(this).parents('.modal').hide();

});