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
                <a href="{{ route('customer.index') }}">Cancel</a>
            </div>
        </div>
        <div class="w-135 p-l-10 p-r-10">
            <div class="text-item"></div>
        </div>
        <div class="w-53 section-subitem-end">
            <div class="text-item-end">
                <a href="{{ route('customer.edit', [$data->id]) }}" class="open-modal-my-profile">
                    <button type="button" class="btn btn-outline-primary fs-16 p-r-unset">Edit</button>
                </a>
            </div>
        </div>
    </div>
    <div>
        <div class="section-image-user">
            <div class="section-image m-b-6">
                <img src="{{ $data->image_url }}" alt="profile_user" class="">
            </div>
            <b class="fs-16 m-t-10">{{ $data->nomor_ktp }}</b>
            <b class="fs-16 m-t-10">{{ $data->name }}</b>
        </div>
    </div>
    <div class="bg-NEUTRAL10 p-t-20 p-l-20 p-r-20 p-b-20">        
        <div class="row">
            <div class="col-md-6">
                <div class="m-b-25 bg-WHITE p-t-15 p-l-20 p-r-20 h-98persen">
                    <div class="border1">
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Phone No</label>
                        </div>
                        <div class="fs-12 text-PRIMARY60 m-b-5">
                            {{ ucwords($data->phone_number) }}
                        </div>
                    </div>
                    <div class="border1 m-t-15">
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Institution</label>
                        </div>
                        <div class="fs-12 m-b-5">
                            {{ ucwords($data->institution) }}
                        </div>
                    </div>
                    <div class="border1 m-t-15">
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Email</label>
                        </div>
                        <div class="fs-12 text-PRIMARY60 m-b-5">
                            {{ ($data->email != null) ? ucwords($data->email) : "-" }}
                        </div>
                    </div>
                    <div class="m-t-15">
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Address</label>
                        </div>
                        <div class="fs-12">
                            {{ ucwords($data->address) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-b-25 bg-WHITE p-t-15 p-l-20 p-r-20 h-98persen">
                    <div>
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Notes</label>
                        </div>
                        <div class="fs-12 m-b-5">
                            {{ ucwords($data->notes) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css-plugins')
<link href="/cms/css/pages/customer-create.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/css/pages/customer-details.css?v={{ $version }}" rel="stylesheet">
@endpush

@push('js-plugins')

@endpush