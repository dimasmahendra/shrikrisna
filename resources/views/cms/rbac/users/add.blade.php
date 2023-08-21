<!-- Modal -->
<div class="modal fade" id="additem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3 b-r-20">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Data</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-item" action="{{ route('rbac.users.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Name</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="username" class="form-control" name="username" placeholder="Input Name" value="">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Email</label>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" class="form-control" name="email" placeholder="Input Email" value="">
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Role</label>
                        </div>
                        <div class="form-group">
                            <select class="form-select" id="id_role" name="id_role">
                                @foreach ($roles as $item)
                                    <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Password</label>
                        </div>
                        <div class="form-group icon-div">
                            <span class="btn-show-pass">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                            <input type="password" id="mainpassword" class="form-control" name="password">
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
                        <li class="d-inline-block me-2 mb-1">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox1" class="form-check-input" name="is_reset" checked>
                                    <label for="checkbox1">Ask for a password change at the next sign-in</label>
                                </div>
                            </div>
                        </li>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Status</label>
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
                    <button type="submit" class="btn text-white bg-PRIMARY-50 w-400 h-60px fs-20">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>