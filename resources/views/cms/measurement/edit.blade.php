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
                            @foreach ($details as $item)
                                @foreach ($item as $subitem)
                                    <tr>
                                        @if ($loop->iteration == 1)
                                            <td rowspan='{{ $subitem->categorydetail->total_rows }}' class="center">{{ $subitem->categorydetail->description }}</td>
                                        @endif
                                        <td class="p-td-unset" width="25%">
                                            <div class="col">
                                                <input type="text" class="form-control" id="details[{{ $subitem->id }}][value]" 
                                                name="details[{{ $subitem->id }}][value][]" value="{{ ($subitem->value == null) ? "" : $subitem->value }}">
                                            </div>
                                        </td>
                                        <td class="p-td-unset">
                                            <div class="col">
                                                <input type="text" class="form-control" id="details[{{ $subitem->id }}][option]" 
                                                name="details[{{ $subitem->id }}][option][]" value="{{ ($subitem->option == null) ? "" : $subitem->option }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
<link href="/cms/css/pages/customer-measurement.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/vendors/uppy/uppy.min.css?v={{ $version }}" rel="stylesheet">
@endpush

@push('js-plugins')
<script src="/cms/vendors/uppy/uppy.min.js"></script>
<script src="/cms/js/uppyuploadfiles.js?v={{ $version }}"></script>
<script>

    const params = {
        fileinput: "#my-file-input", 
        progressbar: ".UppyProgressBar", 
        urlxhr: "/admin/upload-image",
        folder: "customer-measurement/{{ $data->id_customer }}",
        urldelete: "/admin/delete-image/"
    };
    uppyUploadFiles(params);

</script>
@endpush