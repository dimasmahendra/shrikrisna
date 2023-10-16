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
                        @foreach ($data->category->details as $item)
                            @for ($i = 0; $i < $item->total_rows; $i++)
                                <tr>
                                    @if ($i == 0)
                                        <td rowspan='{{ $item->total_rows }}' class="center">{{ $item->description }}</td>
                                    @endif
                                    <td class="p-td-unset" width="25%">
                                        <div class="col">
                                            <div class="h-45 text-center center3">
                                                {{ isset($details[$item->id][$i]["value"]) ? $details[$item->id][$i]["value"] : '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-td-unset">
                                        <div class="col">
                                            <div class="h-45 text-center center3">
                                                {{ isset($details[$item->id][$i]["option"]) ? $details[$item->id][$i]["option"] : '-' }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($data->notes != null)
            <div class="col-md-12 p-r-unset">
                <div class="card m-b-30 p-l-20 p-r-20 p-b-20 p-t-20">
                    {{ $data->notes }}
                </div>
            </div>
        @endif
        <div class="card bg-SECONDARY60" style="margin-bottom: 10px;">
            @include('components.uppy', ['storage' => $data->storages, 'button_show' => false])
        </div>
        @if (Auth::user()->id_role == 1)
            <div class="col-md-12 p-r-unset">
                <button type="button" class="btn btn-WHITE100-red h-40 button-destroy w-100persen text-left"
                    data-url="{{ route('category.measurement.destroy',[$data->id]) }}">
                    Delete
                </button>
            </div>
        @endif
    </div>
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
@endpush

@push('js-plugins')

@endpush