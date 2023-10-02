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
                <a href="{{ route('category.measurement.edit', [$data->id]) }}">
                    <button type="button" class="btn btn-outline-primary fs-14 p-r-unset">Edit</button>
                </a>
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
        <div class="card m-t-30">
            <div class="table-responsive">
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
                                            <div class="h-45 text-center center3">{{ $subitem->value }}</div>
                                        </div>
                                    </td>
                                    <td class="p-td-unset">
                                        <div class="col">
                                            <div class="h-45 text-center center3">{{ $subitem->option }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($data->notes != null)
            <div class="col-md-6 p-r-unset">
                <div class="card m-b-30 p-l-20 p-r-20 p-b-20 p-t-20">
                    {{ $data->notes }}
                </div>
            </div>
        @endif
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