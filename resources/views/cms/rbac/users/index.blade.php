@php
    $title = "User Management";
    $breadcrumbs[] = ["label" => "User Management", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="row">
        <div class="col-md-3 gy-3">
            <form action="{{ route('rbac.users.index') }}" method="get">
                <div class="input-group">
                    <input class="form-control border-end-0" type="search" value="{{ (request()->query("search") != "") ? request()->query("search") : '' }}" id="search-input" name="search" placeholder="Search">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary bg-white border-start-1 border-bottom-1 h-40" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-9 gy-3 d-flex justify-content-end">
            @include('components.filter', ['route' => route('rbac.users.index')])
            @if ($auth_permission['rbac.role.create'])
                <button class="btn btn-secondary m-l-10 float-end h-40 w-125 open-modal" type="button">Add Data</button>
            @endif
        </div>
    </div>
    <div class="card-body-list">
        @if (count($users) > 0)
            <div class="table-responsive">
                <table class="table" id="filterTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-left">User Name</th>
                            <th class="text-left">Email</th>
                            <th class="text-left">Status</th>
                            @if ($auth_permission['rbac.role.edit'] || $auth_permission['rbac.role.destroy'])
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                            <tr>
                                <td width="30%">{{ $item->name }}</td>
                                <td width="30%">{{ $item->email }}</td>
                                <td width="10%">
                                    @if ($item->status == 'active')
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Not Active</span>
                                    @endif
                                </td>
                                @if ($auth_permission['rbac.role.edit'] || $auth_permission['rbac.role.destroy'])
                                    <td class="text-center">
                                        @if ($auth_permission['rbac.role.edit'])
                                            <button type="button" class="btn btn-primary btn-width me-2 master-edit" 
                                                data-master="{{ json_encode([
                                                'id' => $item->id, 
                                                'username' => $item->name,
                                                'email' => $item->email,
                                                'role_id' => $item->role_id,
                                                'status' => $item->status ]) }}">Update</button>
                                        @endif
                                        @if ($auth_permission['rbac.role.destroy'])
                                            @if ($item->id != 1)
                                                <button type="button" class="btn btn-danger btn-width button-destroy"
                                                    data-url="{{ route('rbac.users.destroy',[$item->id]) }}">
                                                    Delete
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 mt-40 mb-60 text-right animate-box" data-animate-effect="fadeInUp">
                    <!-- Pagination -->
                    {{ $users->links('components.paginator') }}
                </div>
            </div>
        @else
            <div class="item-center text-center text-data-not-found">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                No Data Found
            </div>
        @endif
    </div>
</div>
@include('cms.rbac.users.add', $roles)
<div class="modal fade" id="edititem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content"></div>
    </div>
</div>
@endsection

@push('js-plugins')
<script>

    let baseUrl = "{{ route('rbac.users.index') }}";

    $(document).on('change', '#status-filter', function (ev) {
        ev.preventDefault();
        if ($(this).val() == "") {
            window.location = "{{ route('rbac.users.index') }}";
        } else {
            window.location = "{{ route('rbac.users.index') }}?filter=" + $(this).val();
        }
    });

    $(document).on('click', '.open-modal', function (ev) {
        ev.preventDefault();
        $('#additem').modal('show');
    });

    $(document).ready(function () {
        $("#add-item").validate({
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
                    required: true,
                },
                confirmpassword : {
                    minlength : 6,
                    equalTo : "#mainpassword"
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
                    required: "Password is Required",
                },
                confirmpassword: {
                    minlength: "Minimum 6 character",
                    equalTo: "Confirmation password must match the password",
                },
            },
            submitHandler: function (form) {
                let myForm = $('#add-item')[0];  
                let data = new FormData(myForm);

                $.ajax({
                    url: '/admin/rbac/users/store',
                    data: data,
                    processData: false,
                    contentType: false,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        // console.log(data);
                        location.reload();
                    }
                });
            }
        });
    });

    $(document).on('click', '.master-edit', function (ev) {
        var datamaster = $(this).data('master');
        $.ajax({
            url: '/admin/rbac/users/edit',
            data: {
                'datamaster': datamaster
            },
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                $("#edititem").modal("show").find(".modal-content").html(data);
            }
        });
    });
</script>
@endpush