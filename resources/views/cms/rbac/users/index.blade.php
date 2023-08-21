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
    <div class="d-flex m-t-30 section-btn">
        <div class="col-md-6 d-flex">
            @include('components.filter', ['route' => route('rbac.users.index')])
        </div>
        <div class="col-md-6 d-flex">
            <button class="btn btn-PRIMARY60 m-r-20 h-45 w-150 open-modal fw-600 m-l-auto" type="button">Add Data</button>
        </div>
    </div>
    <div class="card-body-list">
        @if (count($users) > 0)
            <div class="table-responsive p-l-20">
                <table class="table" id="filterTable" style="width:98%">
                    <thead>
                        <tr>
                            <th class="text-left fw-600" style="display: none;">ID</th>
                            <th class="text-left fw-600">Name</th>
                            <th class="text-left fw-600">Email</th>
                            <th class="text-left fw-600">Role</th>
                            <th class="text-left fw-600">Status</th>
                            <th class="fw-600" width="40%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                            <tr>
                                <td style="display: none;">{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role->role_name }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Not Active</span>
                                    @endif
                                </td>
                                <td class="text-center row gap-2 justify-content-center">
                                    <button class="btn btn-ORANGE60 me-2 w-125 h-40 modal-reset-password p-unset fw-600" type="button" data-master="{{ json_encode([
                                        'id' => $item->id]) }}">Reset Password</button>
                                    <button type="button" class="btn btn-PRIMARY60 me-2 w-125 h-40 master-edit fw-600" 
                                        data-master="{{ json_encode([
                                        'id' => $item->id, 
                                        'username' => $item->name,
                                        'email' => $item->email,
                                        'id_role' => $item->id_role,
                                        'status' => $item->status ]) }}">Update</button>
                                    @if ($item->id != 1)
                                        <button type="button" class="btn btn-RED60 w-125 h-40 button-destroy fw-600"
                                            data-url="{{ route('rbac.users.destroy',[$item->id]) }}">
                                            Delete
                                        </button>
                                    @endif
                                </td>
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
        <div class="modal-content p-3 b-r-20"></div>
    </div>
</div>

<div class="modal fade" id="modalresetpassword" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content p-3 b-r-20"></div>
    </div>
</div>
@endsection

@push('css-plugins')
<style>
    .section-btn {
        justify-content: space-between;
    }

    @media screen and (max-width: 1199px) {
        .p-l-40 {
            padding-left: 15px; 
        }
        img.logo-image {
            margin-left: 15px;
            margin-right: 50px;
        }

        .navbar-user-name {
            display: none !important;
        }

        .navbar-icon {
            margin: unset !important;
            display: inline-flex;
        }
    }
</style>
@endpush

@push('js-plugins')
<script>

    let baseUrl = "{{ route('rbac.users.index') }}";
    var modules = "User Management";
    var activities = "View User";

    $(document).ready(function () {
        $("#filterTable").dataTable({
            "ordering": true,
            "bPaginate": false,
            "searching": false,
            "lengthChange": false,
            "language": {
                "info": "",
            },
            "order": [[0, 'asc']],
        });
    });

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
                id_role : {
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
                id_role: {
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
                myForm.submit();
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
                $("#edititem").modal("show").find(".modal-content").html(data);
            }
        });
    });

    $(document).on('click', '.modal-reset-password', function (ev) {
        var datamaster = $(this).data('master');
        $.ajax({
            url: '/admin/rbac/users/edit/reset-password',
            data: {
                'datamaster': datamaster
            },
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $("#modalresetpassword").modal("show").find(".modal-content").html(data);
            }
        });
    });
</script>
@endpush