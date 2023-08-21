<div class="modal-header">
    <h5 class="modal-title text-NEUTRAL100 fw-600">Update Data</h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<form id="update-item" action="{{ route('rbac.users.update', [$model['id']]) }}" method="POST">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Name</label>
            </div>
            <div class="form-group">
                <input type="text" id="username" class="form-control" name="username" placeholder="Input Username" value="{{ $model['username'] }}">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Email</label>
            </div>
            <div class="form-group">
                <input type="email" id="email" class="form-control" name="email" placeholder="Input Email" value="{{ $model['email'] }}" readonly>
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Role</label>
            </div>
            <div class="form-group">
                <select class="form-select" id="id_role" name="id_role">
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" {{ ($model['id_role'] == $item->id) ? 'selected' : '' }}>{{ $item->role_name }}</option>
                    @endforeach 
                </select>
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Status</label>
            </div>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input w-30 h-30" type="radio" name="status" id="status1edit" value="active" {{ ($model['status'] == 1) ? 'checked' : '' }} >
                    <label class="form-check-label m-t-6 m-l-10" for="status1edit">Active</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input w-30 h-30" type="radio" name="status" id="status2edit" value="nonactive" {{ ($model['status'] == 0) ? 'checked' : '' }} > 
                    <label class="form-check-label m-t-6 m-l-10" for="status2edit">Not Active</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer custom-hr">
        <button type="submit" class="btn btn-PRIMARY60 w-450 h-60 fs-20">Submit</button>
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
            },
            submitHandler: function (form) {
                let myForm = $('#update-item')[0];  
                myForm.submit();
            }
        });
    });
</script>