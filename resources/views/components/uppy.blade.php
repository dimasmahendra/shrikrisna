<style>
    .UppyProgressBar .uppy-ProgressBar-inner {
        background-color: #50A927;
        box-shadow: 0 0 10px #50A927b3;
    }

    .uppy-ProgressBar {
        height: 5px;
    }

    .wrap-upload-button {
        position: relative;
        overflow: hidden;
        padding-top: 7px;
        font-size: 12px;
        line-height: 16px;
    }

    #my-file-input {
        position: absolute;
        font-size: 50px;
        opacity: 0;
        right: 0;
        top: 0;
        cursor: pointer;
    }

    .img-uppy {
        height: 200px;
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
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    }

</style>

<div class="btn btn-danger w-140 h-30 wrap-upload-button" id="button-upload-image-uppy">
    <i class="bi bi-upload"></i> Click to Upload
    <input class="h-30" type="file" id="my-file-input" multiple>
</div>
<div class="UppyProgressBar m-t-10 m-b-10"></div>
<div class="uploaded-files row" id="section-uploaded-files">
    @if (count($storage) > 0)
        <input type="hidden" name="gallery_img" id="gallery_img" value="1">
        @foreach ($storage as $item)
            <div class="col-md-6" id="gallery-{{ $item->id }}">
                <div class="card m-b-24">
                    <div class="card-content card-img-top card-img-bottom">
                        <img src="{{ $item->url_path }}" class="card-img-top card-img-bottom img-uppy">
                        <button type="button" class="btn btn-danger w-100px h-30 uppy-button-delete" data-url="{{ route('deleteImage',[$item->id]) }}">Delete</button>
                        <input type="hidden" name="storageid[]" value={{ $item->id }}>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <input type="hidden" name="gallery_img" id="gallery_img" value="0">
    @endif
</div>