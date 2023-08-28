@php
    $title = "Customer";
    $breadcrumbs[] = ["label" => "Details Customer", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <div class="section-header">
        <div class="w-53 section-subitem-start">
            <div class="text-item-start">
                <a href="{{ route('customer.details', [$data->id]) }}">Cancel</a>
            </div>
        </div>
        <div class="p-l-10 p-r-10">
            <div class="text-item">New Measurement</div>
        </div>
        <div class="w-53 section-subitem-end">
            <div class="text-item-end">
                <a href="#">
                    <button type="button" class="btn btn-outline-primary fs-16 p-r-unset">Done</button>
                </a>
            </div>
        </div>
    </div>
    <div class="container-measure">
        <div class="section-image-user">
            <div>
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->nomor_ktp }}</strong>
            </div>
            <div class="m-t-10">
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->name }}</strong>
            </div>
            <div class="m-t-25">
                <div class="form-group">
                    <select class="form-select" id="id_category" name="id_category">
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach 
                    </select>
                </div>
            </div>
            <div class="m-t-15">
                <div class="form-group position-relative has-icon-right">
                    <input type="text" id="measurement_date" class="form-control" name="measurement_date" 
                    placeholder="Select Date" value="">
                    <div class="form-control-icon">
                        <i class="icon-calendar fs-25"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-t-25">
            <img class="loader-container" id="loader-container" src="{{ url('cms/images/samples/item-loader.svg') }}" 
            style="display: none; margin: auto; display: block;" />
            <div class="table-responsive" id="layout-measurement">
            </div>
        </div>
    </div>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link href="/cms/css/pages/customer-measurement.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>

    $("#measurement_date").datepicker({
        format: "dd MM yyyy",
        autoclose: true,
        todayHighlight: true,
    }).datepicker("setDate",'now');

    $(document).ready(function() {
        $("#layout-measurement").empty();
        initLayout();
    });

    $(document).on('change', '#id_category', function (ev) {
        $("#layout-measurement").empty();
        initLayout();
    });

    function initLayout() {
        var datamaster = $("#id_category").val();
        $.ajax({
            url: '/admin/customer/measurement/category/' + datamaster,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $("#loader-container").show();
            },
            success: function (data) {
                $("#loader-container").hide();
                $("#layout-measurement").html(data);
            }
        });
    }

</script>
@endpush