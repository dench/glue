$('.block-link').click(function(){
    document.location.href = $(this).find('a').attr('href');
});
var minWidth = 768;
var sidebar = 1;
$(window).resize(function(){
    if ($(this).width() < minWidth) {
        goBottom();
    } else {
        goLeft();
    }
});
if ($(window).width() < minWidth) {
    goBottom();
} else {
    goLeft();
}
function goBottom() {
    var left = $('#sidebarleft');
    var bottom = $('#sidebarbottom');
    if (!sidebar) {
        bottom.html(left.html());
        left.html("");
        sidebar = 1;
    }
}
function goLeft() {
    var left = $('#sidebarleft');
    var bottom = $('#sidebarbottom');
    if (sidebar) {
        left.html(bottom.html());
        bottom.html("");
        sidebar = 0;
    }
}
if (!getCookie('showphones')) {
    $('.fa-phone').each(function(){
        var obj = $(this).parent();
        obj.attr('data-tel', obj.text());
        obj.html('<i class="fa fa-phone"></i> +380 <small>показать номер</small>');
        obj.click(function(e){
            $('.fa-phone').parent().each(function(){
                setCookie('showphones', 1);
                if ($(this).attr('data-tel')) {
                    $(this).html('<i class="fa fa-phone"></i>' + $(this).attr('data-tel'));
                    $(this).attr('data-tel', null);
                    return e.preventDefault();
                }
            });
        });
    });
}
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}