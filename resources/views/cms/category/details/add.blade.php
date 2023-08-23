<!-- Modal -->
<div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3 b-r-20">
            <div class="modal-header">
                <h5 class="modal-title text-NEUTRAL100 fw-600" id="exampleModalLongTitle">Add Data</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-item" action="{{ route('category.details.store', [$data->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Order</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="order" class="form-control currency" name="order" placeholder="Input Order" value="">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Description</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="description" class="form-control" name="description" placeholder="Input Description" value="">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Total Rows</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="total_rows" class="form-control currency" name="total_rows" placeholder="Input Total Rows" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer custom-hr">
                    <button type="submit" class="btn btn-PRIMARY60 w-450 h-60 fs-20">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>