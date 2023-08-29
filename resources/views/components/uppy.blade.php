<style>
    .UppyProgressBar .uppy-ProgressBar-inner {
        background-color: #50A927;
        box-shadow: 0 0 10px #50A927b3;
    }

    .uppy-ProgressBar {
        height: 5px;
    }

    .wrap-upload-button {
        text-align: center;
        margin: auto;
        display: inline-grid;
        align-items: center;
    }

    #my-file-input {
        position: absolute;
        font-size: 50px;
        opacity: 0;
        cursor: pointer;
        width: 100%
    }

    .img-uppy {
        height: 160px;
        object-fit: cover;
        cursor: pointer;
    }

    .card-content:hover img {
        opacity: 0.45;
    }

    .card-content:hover .uppy-button-delete {
        display: block; 
    }

    .uppy-button-delete {
        position: absolute;
        display: none;
        top: 10px;
        right: 10px;
        box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    }

    .row>* {
        max-width: 50%;
    }

    @media (hover: none) {
        .card-content {
            opacity: 1;
        }

        .card-content .uppy-button-delete {
            display: block; 
        }
    }

</style>

<div class="uploaded-files row" id="section-uploaded-files">
    @if (count($storage) > 0)
        <input type="hidden" name="gallery_img" id="gallery_img" value="1">
        @foreach ($storage as $item)
            <div class="col-md-6" id="gallery-{{ $item->id }}">
                <div class="card m-b-24">
                    <div class="card-content card-img-top card-img-bottom">
                        <img src="{{ $item->url_path }}" class="card-img-top card-img-bottom img-uppy">
                        @if ($button_show)
                            <button type="button" class="btn btn-WHITE100 uppy-button-delete" data-url="{{ route('deleteImage',[$item->id]) }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.25 5.25L6.1875 20.25C6.23203 21.1167 6.8625 21.75 7.6875 21.75H16.3125C17.1408 21.75 17.7595 21.1167 17.8125 20.25L18.75 5.25" stroke="#FF0000" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3.75 5.25H20.25H3.75Z" fill="#FF0000"/>
                                    <path d="M3.75 5.25H20.25" stroke="#FF0000" stroke-miterlimit="10" stroke-linecap="round"/>
                                    <path d="M9 5.25V3.375C8.99957 3.22715 9.02837 3.08066 9.08475 2.94397C9.14114 2.80729 9.22399 2.6831 9.32854 2.57854C9.43309 2.47399 9.55728 2.39114 9.69397 2.33476C9.83066 2.27838 9.97714 2.24957 10.125 2.25H13.875C14.0229 2.24957 14.1693 2.27838 14.306 2.33476C14.4427 2.39114 14.5669 2.47399 14.6715 2.57854C14.776 2.6831 14.8589 2.80729 14.9152 2.94397C14.9716 3.08066 15.0004 3.22715 15 3.375V5.25M12 8.25001V18.75M8.625 8.25001L9 18.75M15.375 8.25001L15 18.75" stroke="#FF0000" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>                                
                            </button>
                        @endif
                        <input type="hidden" name="storageid[]" value={{ $item->id }}>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <input type="hidden" name="gallery_img" id="gallery_img" value="0">
    @endif
</div>
@if ($button_show)
    <div class="UppyProgressBar m-t-10 m-b-10"></div>
    <div class="btn btn-PRIMARY60 h-60 fs-16 fw-600 w-100persen wrap-upload-button" id="button-upload-image-uppy">
        Upload Photo
        <input class="h-60" type="file" id="my-file-input">
    </div>
@endif