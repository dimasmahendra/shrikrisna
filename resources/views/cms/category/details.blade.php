@php
    $title = "Detail Category Type";
    $breadcrumbs[] = ["label" => "Details Category", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title fs-20 fw-600 m-b-10">{{ $title }}</h4>
        <div class="col-md-4">
            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Type Name</label>
        </div>
        <div class="fs-16">
            {{ ucwords($data->name) }}
        </div>
    </div>
    <div class="d-flex section-btn">
        <div class="col-md-6 d-flex"></div>
        <div class="col-md-6 d-flex">
            <button class="btn btn-PRIMARY60 m-r-20 h-45 w-150 open-modal fw-600 m-l-auto" type="button" id="button-add-data">Add Data</button>
        </div>
    </div>
    <div class="card-body-list">
        @if (count($details) > 0)
            <div class="table-responsive p-l-20">
                <table class="table" id="filterTable" style="width:98%">
                    <thead>
                        <tr>
                            <th class="text-left fw-600">Order</th>
                            <th class="text-left fw-600">Description</th>
                            <th class="text-left fw-600">Total Rows</th>
                            <th class="no-sort fw-600" width="40%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $key => $item)
                            <tr>
                                <td>{{ $item->order }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->total_rows }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-PRIMARY60 me-2 m-b-5 w-125 h-40 master-edit fw-600" 
                                        data-master="{{ json_encode([
                                        'id' => $item->id, 
                                        'order' => $item->order,
                                        'description' => $item->description,
                                        'total_rows' => $item->total_rows,
                                        'status' => $item->status ]) }}">Update
                                    </button>
                                    <button type="button" class="btn btn-RED60 me-2 m-b-5 w-125 h-40 button-destroy fw-600"
                                        data-url="{{ route('category.details.destroy',[$item->id]) }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 mt-40 mb-60 text-right animate-box" data-animate-effect="fadeInUp">
                    <!-- Pagination -->
                    {{ $details->links('components.paginator') }}
                </div>
            </div>
        @else
            <div class="text-center text-data-not-found">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                There was <span class="text-PRIMARY60">no Data Found</span>
            </div>
        @endif
    </div>
    <div class="p-t-20 p-b-20 custom-hr">
        <div id="button-actions">
            <a href="{{ route('category.details.cancel', [$data->id]) }}">
                <button type="button" class="btn btn-NEUTRAL60 w-150 h-45 m-r-15 fw-600">Cancel</button>
            </a>
            <a href="{{ route('category.details.submit', [$data->id]) }}">
                <button type="button" class="btn btn-PRIMARY60 w-150 h-45 m-r-15 fw-600">Submit</button>
            </a>
        </div>
    </div>
</div>
@include('cms.category.details.add')
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
<script src="/cms/vendors/maskmoney/maskmoney.js"></script>
<script>

    let baseUrl = "{{ route('category.details', [$data->id]) }}";

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
            "columnDefs": [{
                targets: 'no-sort',
                orderable: false
            }],
        });
    });

    $(document).on('click', '.open-modal', function (ev) {
        ev.preventDefault();
        $('#additem').modal('show');
    });

    $(".currency").maskMoney({
        thousands: ".",
        decimal:',',
        precision: 0,
        affixesStay: false,
        allowZero: true
    });

    jQuery.validator.addMethod("notEqual", function(value, element, param) {
        var result = true;
        var defaultdata = $(param).val();
        const obj = JSON.parse(defaultdata);

        $.each(obj, function(i, v) {
            if (v == value) {
                result = false;
                return false;
            }
        });
        return result; // Value harus false
    });

    $(document).ready(function () {
        $("#add-item").validate({
            errorClass: 'was-validated',
            rules : {
                order : {
                    required: true,
                    notEqual: "#editusedtopic"
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
                    notEqual: "This field must be unique.",
                },
                description: {
                    required: "This field is Required",
                },
                total_rows: {
                    required: "This field is Required",
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
            url: '/admin/category/details/edit',
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
</script>
@endpush