
(function ($) {
    "use strict";

    /*================================================================== */
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('bi-eye-slash');
            $(this).find('i').addClass('bi-eye');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('bi-eye-slash');
            $(this).find('i').removeClass('bi-eye');
            showPass = 0;
        }
    });
})(jQuery);