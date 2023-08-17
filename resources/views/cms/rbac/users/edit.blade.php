<div class="modal-header">
    <h5 class="modal-title">Update Data</h5>
</div>
<form id="update-item" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> User Name</label>
            </div>
            <div class="form-group">
                <input type="text" id="username" class="form-control" name="username" placeholder="Input Username" value="{{ $model['username'] }}">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Email</label>
            </div>
            <div class="form-group">
                <input type="email" id="email" class="form-control" name="email" placeholder="Input Email" value="{{ $model['email'] }}" readonly>
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Role</label>
            </div>
            <div class="form-group">
                <select class="form-select" id="role_id" name="role_id">
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" {{ ($model['role_id'] == $item->id) ? 'selected' : '' }}>{{ $item->role_name }}</option>
                    @endforeach 
                </select>
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Password</label>
            </div>
            <div class="form-group icon-div">
                <span class="btn-show-pass-2">
                    <i class="bi bi-eye-slash"></i>
                </span>
                <input type="password" id="mainpasswordedit" class="form-control" name="password">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-6">
                <label class="text-label pb-2"><span class="text-danger">*</span> Confirmation Password</label>
            </div>
            <div class="form-group icon-div">
                <span class="btn-show-pass-2">
                    <i class="bi bi-eye-slash"></i>
                </span>
                <input type="password" id="confirmpassword" class="form-control" name="confirmpassword">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2"><span class="text-danger">*</span> Status</label>
            </div>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input w-30 h-30" type="radio" name="status" id="status1" value="active" {{ ($model['status'] == "active") ? 'checked' : '' }} >
                    <label class="form-check-label m-t-6 m-l-10" for="status1">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input w-30 h-30" type="radio" name="status" id="status2" value="nonactive" {{ ($model['status'] == "nonactive") ? 'checked' : '' }} > 
                    <label class="form-check-label m-t-6 m-l-10" for="status2">Not Active</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer custom-hr">
        <button type="button" class="btn btn-outline-dark w-125 h-40" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-brownis w-125 h-40" id="button-edit-master" data-id="{{ $model['id'] }}">Submit</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#update-item").validate({
            errorClass: 'was-validated',
            rules : {
                username : {
                    required: true,
                },
                email : {
                    required: true,
                },
                role_id : {
                    required: true,
                },
                password : {
                    minlength : 6,
                },
                confirmpassword : {
                    minlength : 6,
                    equalTo : "#mainpasswordedit"
                }
            },
            messages: {
                username: {
                    required: "Username is Required",
                },
                email: {
                    required: "Email is Required",
                },
                role_id: {
                    required: "Role is Required",
                },
                password: {
                    minlength: "Minimum 6 character",
                },
                confirmpassword: {
                    minlength: "Minimum 6 character",
                    equalTo: "Confirmation password must match the password",
                },
            },
            submitHandler: function (form) {
                let myForm = $('#update-item')[0];  
                let data = new FormData(myForm);
                var id = $("#button-edit-master").data('id');

                $.ajax({
                    url: '/admin/rbac/users/update/' + id,
                    data: data,
                    processData: false,
                    contentType: false,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) { 
                        console.log(data);
                        $("#edititem").modal("hide");
                        location.reload();
                    }
                });
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