$(function () {
    var showPassOldpassword = 0;
    $('.btn-show-pass-oldpassword').on('click', function(){
        if(showPassOldpassword == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('bi-eye-slash');
            $(this).find('i').addClass('bi-eye');
            showPassOldpassword = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('bi-eye-slash');
            $(this).find('i').removeClass('bi-eye');
            showPassOldpassword = 0;
        }
    });

    var showPassMainpassword = 0;
    $('.btn-show-pass-mainpassword').on('click', function(){
        if(showPassMainpassword == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('bi-eye-slash');
            $(this).find('i').addClass('bi-eye');
            showPassMainpassword = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('bi-eye-slash');
            $(this).find('i').removeClass('bi-eye');
            showPassMainpassword = 0;
        }
    });

    var showPassConfirmpassword = 0;
    $('.btn-show-pass-confirmpassword').on('click', function(){
        if(showPassConfirmpassword == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('bi-eye-slash');
            $(this).find('i').addClass('bi-eye');
            showPassConfirmpassword = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('bi-eye-slash');
            $(this).find('i').removeClass('bi-eye');
            showPassConfirmpassword = 0;
        }
    });
});

$(document).ready(function () {
    $("#form-change-password-general").validate({
        errorClass: 'was-validated',
        rules : {
            oldpassword : {
                minlength : 6,
                required: true,
            },
            changepassword : {
                minlength : 6,
                required: true,
            },
            changeconfirmpassword : {
                minlength : 6,
                equalTo : "#changepassword"
            }
        },
        messages: {
            oldpassword: {
                required: "Old Password is Required",
            },
            changepassword: {
                minlength: "Minimum 6 character",
                required: "Password is Required",
            },
            changeconfirmpassword: {
                minlength: "Minimum 6 character",
                equalTo: "Confirmation password must match the password",
            },
        },
        submitHandler: function (form) {
            let myForm = $('#form-change-password-general')[0];  
            myForm.submit();
        }
    });
});

$(document).on('click', '.open-modal-change-password', function (ev) {
    ev.preventDefault();
    $('#change-password-general').modal('show');
});