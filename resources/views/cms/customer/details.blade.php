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
                <a href="{{ route('customer.edit', [$data->id]) }}">
                    <button type="button" class="btn btn-outline-primary fs-16 p-r-unset">Edit</button>
                </a>
            </div>
        </div>
    </div>
    <div>
        <div class="section-image-user">
            <div class="section-image m-b-6">
                <img src="{{ $data->image_url }}" alt="profile_user" class="h-180 w-180 image-user">
            </div>
            <strong class="fs-16 m-t-10 text-SECONDARY60 no-formating">{{ $data->nomor_ktp }}</strong>
            <strong class="fs-16 m-t-10 text-SECONDARY60">{{ $data->name }}</strong>
        </div>
    </div>
    <div class="m-t-10 p-l-20 p-r-50 d-flex">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($gallery as $item_gallery)
                    <div class="swiper-slide">
                        <img src="{{ $item_gallery->url_path }}" alt="{{ $item_gallery->id }}">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @if (count($gallery) > 0)
            <div class="button-link-custom">
                <div
                    style="width: 20px; height: 20px; position: relative; border-radius: 50px; overflow: hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29289 14.7071C6.90237 14.3166 6.90237 13.6834 7.29289 13.2929L10.5858 10L7.29289 6.70711C6.90237 6.31658 6.90237 5.68342 7.29289 5.29289C7.68342 4.90237 8.31658 4.90237 8.70711 5.29289L12.7071 9.29289C13.0976 9.68342 13.0976 10.3166 12.7071 10.7071L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071Z" fill="#006EE9"/>
                    </svg>
                </div>
            </div>
        @endif
    </div>
    <div class="bg-NEUTRAL10 p-t-20 p-l-20 p-r-20 p-b-20">        
        <div class="row">
            <div class="col-md-6 p-b-10">
                <div class="bg-WHITE p-t-15 p-l-20 p-r-20 p-b-20 h-98persen">
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
            <div class="col-md-6 p-b-10">
                <div class="bg-WHITE p-t-15 p-l-20 p-r-20 p-b-20 h-98persen">
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
            <div class="col-md-12 p-b-10">
                <div class="bg-WHITE p-t-15 p-l-20 p-r-20 p-b-20 h-98persen">
                    <div>
                        <div class="col-md-4">
                            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Last Measurement</label>
                        </div>
                        @foreach ($measurement as $item)
                            <div class="border1 m-t-15">
                                <div class="fs-12 m-b-5 d-flex section-btn">
                                    <p class="text-PRIMARY60">{{ ($item->category != null) ? ucwords($item->category->name) : "-" }}</p>
                                    <p class="text-date">{{ date("d F Y", strtotime($item->measurement_date)) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <a href="{{ route('category.measurement.create', [$data->id]) }}">
                    <button type="button" class="btn btn-PRIMARY60 h-60 fs-16 fw-600 w-100persen">Add Measurement</button>
                </a>                
            </div>
        </div>
    </div>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link href="/cms/css/pages/customer-details.css?v={{ $version }}" rel="stylesheet">
<link rel="stylesheet" href="/cms/vendors/swiper/swiper-bundle.min.css" />
@endpush

@push('js-plugins')
<script src="/cms/vendors/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            500: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            590: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            640: {
                slidesPerView: 5,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 6,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 7,
                spaceBetween: 10,
            },
            1280: {
                slidesPerView: 8,
                spaceBetween: 10,
            },
            1360: {
                slidesPerView: 9,
                spaceBetween: 10,
            },
            1920: {
                slidesPerView: 11,
                spaceBetween: 10,
            },
        },
    });
</script>
@endpush