@php
    $title = "Gallery";
    $breadcrumbs[] = ["label" => "Gallery", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <div class="section-header m-b-25">
        <div class="w-53 section-subitem-start">
            <div class="text-item-start">
                <a href="{{ route('customer.details', [$data->id]) }}">Cancel</a>
            </div>
        </div>
        <div class="p-l-10 p-r-10">
            <div class="text-item">Gallery</div>
        </div>
        <div class="w-53 section-subitem-end">
            <div class="text-item-end">
                <button type="button" class="btn btn-outline-primary fs-14 p-r-unset">Upload</button>
            </div>
        </div>
    </div>
    <div class="container-measure">
        @if (count($gallery) > 0)
            <div class="gallery-container d-flex align-items-center justify-content-center">
                <div id="gallery-container" class="row p-l-2 p-r-2">
                    @foreach ($gallery as $item)
                        <a data-lg-size="1400-1400" class="d-flex gallery-item col-md-4 p-l-2 p-r-2 p-b-4"
                            data-src="{{ $item->url_path }}"
                            data-sub-html="<p> {{ $item->measurement->measurement_date }} - {{ $item->customer->name }} - {{ $item->measurement->category->name }}</p>">
                            <img class="img-fluid" src="{{ $item->url_path }}" />
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center text-data-not-found" style="margin-top: 150px;">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                No Data Found
            </div>
        @endif
    </div>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link href="/cms/css/pages/customer-gallery.css?v={{ $version }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lg-thumbnail.css">
@endpush

@push('js-plugins')
<script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.min.js"></script>
<script>
    const lg = lightGallery(document.getElementById("gallery-container"), {
        plugins: [lgThumbnail],
        enableDrag: true,
        enableSwipe: true,
        mobileSettings: {
            controls: false,
            showCloseIcon: true,
            download: true,
            rotate: true
        }
    });
</script>
@endpush