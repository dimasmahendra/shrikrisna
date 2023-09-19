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
            <div class="text-item-end" style="cursor: pointer;">
                <div class="wrap-upload-button fs-15" id="button-upload-image-uppy">
                    Upload
                    <input type="file" accept="image/*" id="gallery_file_input">
                </div>
            </div>
        </div>
    </div>
    <div class="container-measure">
        <div class="gallery-container align-items-center">
            <div id="gallery-container" class="row p-l-2 p-r-2">
                @if (count($gallery) > 0)
                    @foreach ($gallery as $item)
                        <a data-lg-size="1400-1400" class="d-flex gallery-item col-md-4 p-l-2 p-r-2 p-b-4"
                            data-src="{{ $item->url_path }}"
                            data-sub-html="<p> {{ $item->created_at }} - {{ $item->customer->name }}</p>">
                            <img class="img-fluid" src="{{ $item->url_path }}" />
                        </a>
                    @endforeach                    
                @endif
            </div>
            @if (count($gallery) == 0)
                <div class="text-center text-data-not-found center" id="text_no_data">
                    <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                    No Data Found
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('meta-custom')
<meta name="format-detection" content="telephone=no">
@endpush

@push('css-plugins')
<link href="/cms/css/pages/customer-gallery.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/vendors/lightgallery/lightgallery.min.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/vendors/lightgallery/lg-thumbnail.css?v={{ $version }}" rel="stylesheet">
@endpush

@push('js-plugins')
<script src="/cms/vendors/lightgallery/lightgallery.min.js"></script>
<script src="/cms/vendors/lightgallery/lg-thumbnail.min.js"></script>
<script>
    const lg = lightGallery(document.getElementById("gallery-container"), {
        plugins: [lgThumbnail],
        mobileSettings: {
            controls: false,
            download: true,
            rotate: true
        }
    });

    $(document).on('change', '#gallery_file_input', function(e) {
        var file = this.files[0];
        var data = new FormData();
        data.append("file", file);
        data.append("folder", "customer-measurement/{{ $data->id }}");
        data.append("savestorage", true);
        
        $.ajax({
            url: '/admin/customer/gallery/upload',
            data: data,
            contentType: false,
            processData: false,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $("#text_no_data").hide();
                const parentElement = document.getElementById('gallery-container');
                parentElement.insertAdjacentHTML('afterbegin', data);
                lg.refresh();
            },
            error: function (resp) {
                console.log(resp);
            }
        });
        e.preventDefault();
    });
</script>
@endpush