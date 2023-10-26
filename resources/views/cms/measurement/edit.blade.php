@php
    $title = "Edit Measurement";
    $breadcrumbs[] = ["label" => "Edit Measurement", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <form action="{{ route('category.measurement.update', [$data->id]) }}" method="POST" enctype="multipart/form-data" id="formcreate">
        {{ csrf_field() }}
        <div class="section-header">
            <div class="w-53 section-subitem-start">
                <div class="text-item-start">
                    <a href="{{ route('customer.details', [$data->id_customer]) }}" class="fs-14">Cancel</a>
                </div>
            </div>
            <div class="p-l-10 p-r-10">
                <div class="text-item">Edit Measurement</div>
            </div>
            <div class="w-53 section-subitem-end">
                <div class="text-item-end">
                    <button type="submit" class="btn btn-outline-primary fs-14 p-r-unset">Update</button>
                </div>
            </div>
        </div>
        <div class="container-measure">
            <div class="section-image-user">
                <div class="m-t-15">
                    <strong class="fs-16 text-SECONDARY60 center2">{{ $data->customer->nomor_ktp }}</strong>
                </div>
                <div class="m-t-15">
                    <strong class="fs-16 text-SECONDARY60 center2">{{ $data->customer->name }}</strong>
                </div>
                <div class="m-t-15">
                    <strong class="fs-16 text-SECONDARY60 center2">{{ $data->category->name }}</strong>
                </div>
                <div class="m-t-15">
                    <strong class="fs-16 text-SECONDARY60 center2">{{ date("d F Y", strtotime($data->measurement_date)) }}</strong>
                </div>
            </div>
            <div class="card m-t-10">
                <div class="table-responsive" id="layout-measurement">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-PRIMARY90 fw-600 col-2">Description</th>
                                <th class="text-PRIMARY90 fw-600 col-10" colspan="2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $details = $data->items->groupBy('id_master_category_details');
                            @endphp
                            @foreach ($data->category->details as $item)
                                @for ($i = 0; $i < $item->total_rows; $i++)
                                    <tr>
                                        @if ($i == 0)
                                            <td rowspan='{{ $item->total_rows }}' class="center">{{ $item->description }}</td>
                                        @endif
                                        @if (isset($details[$item->id][$i]["id"]))
                                            <td class="p-td-unset" width="25%">
                                                <div class="col">
                                                    <input type="text" class="form-control" id="details[{{ $details[$item->id][$i]["id"] }}][value]" 
                                                    name="details[{{ $details[$item->id][$i]["id"] }}][value][]" 
                                                    value="{{ isset($details[$item->id][$i]["value"]) ? $details[$item->id][$i]["value"] : '' }}">
                                                </div>
                                            </td>
                                            <td class="p-td-unset">
                                                <div class="col">
                                                    <input type="text" class="form-control" id="details[{{ $details[$item->id][$i]["id"] }}][option]" 
                                                    name="details[{{ $details[$item->id][$i]["id"] }}][option][]" 
                                                    value="{{ isset($details[$item->id][$i]["option"]) ? $details[$item->id][$i]["option"] : '' }}">
                                                </div>
                                            </td>
                                        @else
                                            <td class="p-td-unset" width="25%">
                                                <div class="col">
                                                    <input type="text" class="form-control" id="newdetails[{{ $item->id }}][value]" 
                                                    name="newdetails[{{ $item->id }}][value][]" 
                                                    value="{{ isset($details[$item->id][$i]["value"]) ? $details[$item->id][$i]["value"] : '' }}">
                                                </div>
                                            </td>
                                            <td class="p-td-unset">
                                                <div class="col">
                                                    <input type="text" class="form-control" id="newdetails[{{ $item->id }}][option]" 
                                                    name="newdetails[{{ $item->id }}][option][]" 
                                                    value="{{ isset($details[$item->id][$i]["option"]) ? $details[$item->id][$i]["option"] : '' }}">
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endfor
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 p-r-unset">
                <div class="m-b-30">
                    <textarea id="notes" class="form-textarea" 
                    placeholder="Notes" rows="4" name="notes">{{ $data->notes }}</textarea>
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
<link rel="preload" href="/cms/vendors/uppy/uppy.min.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/uppy/uppy.min.css?v={{ $version }}">
</noscript>
@endpush

@push('js-plugins')
<script defer src="/cms/vendors/resizeimage/resizeme.js?v={{ $version }}"></script>
<script defer src="/cms/vendors/uppy/uppy.min.js"></script>
<script defer src="/cms/js/uppyuploadfiles.js?v={{ $version }}"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $('#formcreate').submit(function() {
                $("body").addClass("loading");
            });
            
            const params = {
                fileinput: "#my-file-input", 
                progressbar: ".UppyProgressBar", 
                urlxhr: "/admin/upload-image",
                folder: "customer-measurement/{{ $data->id_customer }}",
                urldelete: "/admin/delete-image/"
            };
            uppyUploadFiles(params);
        })(jQuery);
    });
</script>
@endpush