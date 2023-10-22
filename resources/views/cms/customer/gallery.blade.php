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
                        <a data-lg-size="1400-1400" class="d-flex gallery-item col-md-4 p-l-2 p-r-2 p-b-4" data-idg="{{ $item->id }}" data-id_customer="{{ $item->id_customer }}"
                            data-src="{{ $item->url_path }}"
                            data-sub-html="<p> {{ $item->created_at }} - {{ $item->customer->name }}</p>">
                            <img class="img-fluid" src="{{ $item->url_path }}" data-ids="{{ $item->id }}" data-id_customer="{{ $item->id_customer }}" />
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
<style>
    .lg-delete svg{
        fill: #999
    }
</style>
@endpush

@push('js-plugins')
<script src="/cms/vendors/lightgallery/lightgallery.min.js"></script>
<script src="/cms/vendors/lightgallery/lg-thumbnail.min.js"></script>
<script src="/cms/vendors/resizeimage/resizeme.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {

            const deleteRoute = "{{ env('APP_URL') }}"
            const $lg = document.getElementById('gallery-container');
            const lg = lightGallery($lg, {
                plugins: [lgThumbnail],
                mobileSettings: {
                    controls: false,
                    download: true,
                    rotate: true
                }
            });

            $lg.addEventListener('click', function (event) {
                var id = event.target.getAttribute('data-ids');
                var id_customer = event.target.getAttribute('data-id_customer');
                $("#lg-delete").remove();
                const deleteIcon =
                `<span id="lg-delete" class="lg-icon lg-delete button-destroy" data-url="` + deleteRoute + `/admin/customer/gallery/destroy/` + id +`/` + id_customer + `">
                    <svg width="24px" height="24px" class="v1262d JUQOtc" viewBox="0 0 24 24">
                        <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13zM9 8h2v9H9zm4 0h2v9h-2z"></path>
                    </svg>
                <span>`;
                $('.lg-toolbar').append(deleteIcon);
            });

            $lg.addEventListener('lgBeforeSlide', function (event) {
                var index_id = event.detail.index;
                var id = lg.items[index_id].getAttribute('data-idg');
                var id_customer = lg.items[index_id].getAttribute('data-id_customer');
                $("#lg-delete").remove();
                const deleteIcon =
                `<span id="lg-delete" class="lg-icon lg-delete button-destroy" data-url="` + deleteRoute + `/admin/customer/gallery/destroy/` + id +`/` + id_customer + `">
                    <svg width="24px" height="24px" class="v1262d JUQOtc" viewBox="0 0 24 24">
                        <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13zM9 8h2v9H9zm4 0h2v9h-2z"></path>
                    </svg>
                <span>`;
                $('.lg-toolbar').append(deleteIcon);
            });

            $(document).on('change', '#gallery_file_input', function(e) {

                /* 
                    2*1024*1024 = 2MB
                */
                reduceFileSize(this.files[0], 2*1024*1024, 1200, 1200, 0.9, blob => {
                    var data = new FormData();
                    data.append("file", blob);
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
                });                
                e.preventDefault();
            });
        })(jQuery);
    });
</script>
@endpush