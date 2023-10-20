@php
    $title = "New Measurement";
    $breadcrumbs[] = ["label" => "New Measurement", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <form action="{{ route('category.measurement.store', [$data->id]) }}" method="POST" enctype="multipart/form-data" id="formcreate">
        {{ csrf_field() }}
        <div class="section-header">
            <div class="w-53 section-subitem-start">
                <div class="text-item-start">
                    <a href="{{ route('customer.details', [$data->id]) }}">Cancel</a>
                </div>
            </div>
            <div class="p-l-10 p-r-10">
                <div class="text-item">New Measurement</div>
            </div>
            <div class="section-subitem-end">
                <div class="text-item-end">
                    <button type="submit" class="btn btn-outline-primary fs-14 p-r-unset">Done</button>
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
            <div class="card m-t-10">
                <img class="loader-container" id="loader-container" src="{{ url('cms/images/samples/item-loader.svg') }}" 
                style="display: none; margin: auto; display: block;" />
                <div class="table-responsive" id="layout-measurement">
                </div>
            </div>
            <div class="col-md-12 p-r-unset">
                <div class="m-b-15">
                    <textarea id="notes" class="form-textarea" 
                    placeholder="Notes" rows="4" name="notes">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="card bg-SECONDARY60">
                @include('components.uppy', ['storage' => $storage, 'button_show' => true])
            </div>
        </div>
    </form>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link rel="preload" href="/cms/css/pages/customer-measurement.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/pages/customer-measurement.css?v={{ $version }}">
</noscript>
<link rel="preload" href="/cms/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
</noscript>
<link rel="preload" href="/cms/vendors/uppy/uppy.min.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/uppy/uppy.min.css?v={{ $version }}">
</noscript>
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/cms/vendors/resizeimage/resizeme.js"></script>
<script defer src="/cms/vendors/uppy/uppy.min.js"></script>
<script defer src="/cms/js/uppyuploadfiles.js?v={{ $version }}"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $('#formcreate').submit(function() {
                $("body").addClass("loading");
            });

            $("#measurement_date").datepicker({
                format: "dd MM yyyy",
                autoclose: true,
                todayHighlight: true,
            }).datepicker("setDate",'now');

            const params = {
                fileinput: "#my-file-input", 
                progressbar: ".UppyProgressBar", 
                urlxhr: "/admin/upload-image",
                folder: "customer-measurement/{{ $data->id }}",
                urldelete: "/admin/delete-image/"
            };
            uppyUploadFiles(params);

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
        })(jQuery);
    });
</script>
@endpush