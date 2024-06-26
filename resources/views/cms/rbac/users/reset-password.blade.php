<div class="modal-header">
    <h5 class="modal-title text-NEUTRAL100 fw-600">Reset Password</h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<form id="formmodalresetpassword" action="{{ route('rbac.users.edit.reset-password', [$model['id']]) }}" method="POST">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Password</label>
            </div>
            <div class="form-group icon-div">
                <span class="btn-show-pass">
                    <i class="bi bi-eye-slash"></i>
                </span>
                <input type="password" id="mainpasswordedit" class="form-control" name="password">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-6">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Confirmation Password</label>
            </div>
            <div class="form-group icon-div">
                <span class="btn-show-pass-2">
                    <i class="bi bi-eye-slash"></i>
                </span>
                <input type="password" id="confirmpassword" class="form-control" name="confirmpassword">
            </div>
        </div>
    </div>
    <div class="modal-footer custom-hr">
        <button type="submit" class="btn btn-PRIMARY60 w-450 h-60 fs-20">Submit</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#formmodalresetpassword").validate({
            errorClass: 'was-validated',
            rules : {
                password : {
                    required: true,
                    minlength : 6,
                },
                confirmpassword : {
                    required: true,
                    minlength : 6,
                    equalTo : "#mainpasswordedit"
                }
            },
            messages: {
                password: {
                    required: "This field is Required",
                    minlength: "Minimum 6 character",
                },
                confirmpassword: {
                    required: "This field is Required",
                    minlength: "Minimum 6 character",
                    equalTo: "Confirmation password must match the password",
                },
            },
            submitHandler: function (form) {
                let myForm = $('#formmodalresetpassword')[0];  
                myForm.submit();
            }
        });

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

        var showPass2 = 0;
        $('.btn-show-pass-2').on('click', function(){
            if(showPass2 == 0) {
                $(this).next('input').attr('type','text');
                $(this).find('i').removeClass('bi-eye-slash');
                $(this).find('i').addClass('bi-eye');
                showPass2 = 1;
            }
            else {
                $(this).next('input').attr('type','password');
                $(this).find('i').addClass('bi-eye-slash');
                $(this).find('i').removeClass('bi-eye');
                showPass2 = 0;
            }
        });
    });
</script>