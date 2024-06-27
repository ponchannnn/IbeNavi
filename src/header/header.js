$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.sHeader').addClass('scrolled');
        } else {
            $('.sHeader').removeClass('scrolled');
        }
    });
});

$("#sHeader-login").on("click", function () {
    location = '/login/login';
})

$("#sHeader-signup").on("click", function () {
    location = '/create_account/create_account';
})

$("#sHeader-logout").on("click", function () {
    location = '/logout/logout';
})