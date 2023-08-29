@php
    $title = "Details Measurement";
    $breadcrumbs[] = ["label" => "Details Measurement", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <div class="section-header">
        <div class="w-53 section-subitem-start">
            <div class="text-item-start d-flex">
                <i class="icon-vector fs-20 text-PRIMARY60"></i>
                <a class="text-PRIMARY60" href="{{ route('customer.details', [$data->customer->id]) }}">Customer</a>
            </div>
        </div>
        <div class="p-l-10 p-r-10"></div>
        <div class="w-53 section-subitem-end">
            <div class="text-item-end">
                <a href="{{ route('category.measurement.create', [$data->customer->id]) }}">
                    <button type="button" class="btn btn-outline-primary fs-14 p-r-unset">Add</button>
                </a>
            </div>
        </div>
    </div>
    <div class="container-measure">
        <div class="section-image-user">
            <div>
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->customer->nomor_ktp }}</strong>
            </div>
            <div class="m-t-10">
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->customer->name }}</strong>
            </div>
            <div class="m-t-10">
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->category->name }}</strong>
            </div>
            <div class="m-t-10">
                <strong class="fs-16 text-SECONDARY60 center2">{{ $data->measurement_date }}</strong>
            </div>
        </div>
        <div class="card m-t-10">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-PRIMARY90 fw-600 col-6">Description</th>
                            <th class="text-PRIMARY90 fw-600 col-6" colspan="2">Value</th>
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
                                    <td class="p-td-unset">
                                        <div class="col">
                                            <input type="text" class="form-control" id="details[{{ $subitem->id_master_category_details }}][value]" 
                                            name="details[{{ $subitem->id_master_category_details }}][value][]" value="{{ $subitem->value }}">
                                        </div>
                                    </td>
                                    <td class="p-td-unset">
                                        <div class="col">
                                            <input type="text" class="form-control" id="details[{{ $subitem->id_master_category_details }}][option]" 
                                            name="details[{{ $subitem->id_master_category_details }}][option][]" 
                                            value="{{ $subitem->option }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card bg-SECONDARY60">
            @include('components.uppy', ['storage' => $data->storages, 'button_show' => false])
        </div>
    </div>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link href="/cms/css/pages/customer-measurement.css?v={{ $version }}" rel="stylesheet">
@endpush

@push('js-plugins')

@endpush