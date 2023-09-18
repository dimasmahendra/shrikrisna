<!-- Modal -->
<div class="modal fade" id="change-password-general" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Password</h5>
            </div>
            <form id="form-change-password-general" method="POST" action="{{ route('admin.change-password') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Old Password</label>
                        </div>
                        <div class="form-group icon-div">
                            <span class="btn-show-pass-oldpassword">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                            <input type="password" id="oldpassword" class="form-control" name="oldpassword" placeholder="Input Password">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Password</label>
                        </div>
                        <div class="form-group icon-div">
                            <span class="btn-show-pass-mainpassword">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                            <input type="password" id="changepassword" class="form-control"  placeholder="Input Password" name="changepassword">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-6">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Confirmation Password</label>
                        </div>
                        <div class="form-group icon-div">
                            <span class="btn-show-pass-confirmpassword">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                            <input type="password" id="changeconfirmpassword" class="form-control"  placeholder="Input Confirmation Password" name="changeconfirmpassword">
                        </div>
                    </div>
                </div>
                <div class="modal-footer custom-hr">
                    <button type="button" class="btn btn-outline-PRIMARY60 w-125 h-40" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-PRIMARY60 w-125 h-40">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>