<!-- Modal -->
<div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3 b-r-20">
            <div class="modal-header">
                <h5 class="modal-title text-NEUTRAL100 fw-600" id="exampleModalLongTitle">Add Data</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-item" action="{{ route('category.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Name</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="name" class="form-control" name="name" placeholder="Input Name" value="">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2 fw-600"><span class="text-danger">*</span> Status</label>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input w-30 h-30" type="radio" name="status" id="status1" value="active" checked>
                                <label class="form-check-label m-t-6 m-l-10" for="status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input w-30 h-30" type="radio" name="status" id="status2" value="nonactive">
                                <label class="form-check-label m-t-6 m-l-10" for="status2">Not Active</label>
                            </div>
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