
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