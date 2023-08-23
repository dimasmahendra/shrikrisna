<div class="modal-header">
    <h5 class="modal-title text-NEUTRAL100 fw-600">Update Data</h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<form id="update-item" action="{{ route('category.details.update', [$model['id']]) }}" method="POST">
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Order</label>
            </div>
            <div class="form-group">
                <input type="text" id="order" class="form-control currency" name="order" placeholder="Input Order" value="{{ $model['order'] }}">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Description</label>
            </div>
            <div class="form-group">
                <input type="text" id="description" class="form-control" name="description" placeholder="Input Description" value="{{ $model['description'] }}">
            </div>
        </div>
        <div class="pb-2">
            <div class="col-md-4">
                <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Total Rows</label>
            </div>
            <div class="form-group">
                <input type="text" id="total_rows" class="form-control currency" name="total_rows" placeholder="Input Total Rows" value="{{ $model['total_rows'] }}">
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
                order : {
                    required: true,
                },
                description : {
                    required: true,
                },
                total_rows : {
                    required: true,
                },
            },
            messages: {
                order: {
                    required: "This field is Required",
                },
                description: {
                    required: "This field is Required",
                },
                total_rows: {
                    required: "This field is Required",
                },
            },
            submitHandler: function (form) {
                let myForm = $('#update-item')[0];  
                myForm.submit();
            }
        });
    });
</script>