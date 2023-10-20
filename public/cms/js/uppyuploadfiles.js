function uppyUploadFiles(params) {

    // console.log(params);

    const { XHRUpload, FileInput, ProgressBar } = Uppy
    const fileInput = document.querySelector(params.fileinput)

    var uppy = new Uppy.Core({ 
            debug: true, 
            autoProceed: true,
            restrictions: {
                minNumberOfFiles: 1,
                allowedFileTypes: ['image/gif', 'image/png', 'image/jpg', 'image/jpeg', 'image/webp'],
            }
        })
        .use(ProgressBar, {
            target: params.progressbar,
            hideAfterFinish: true,
        })
        .use(XHRUpload, {
            limit: 10,
            endpoint: params.urlxhr,
            formData: true,
            fieldName: 'file',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })

    uppy.setMeta({ folder: params.folder })
    uppy.setMeta({ savestorage: true })

    fileInput.addEventListener('change', (event) => {
        const files = Array.from(event.target.files)

        files.forEach((file) => {
            try {
                reduceFileSize(file, 2*1024*1024, 1200, 1200, 0.9, blob => {
                    uppy.addFile({
                        source: 'blob input',
                        name: blob.name,
                        type: blob.type,
                        data: blob,
                    })
                });
            } catch (err) {
                msgtext = "File : " + file.name + " <br /> " + err;
                if (err.isRestriction) {
                    Toastify({
                        text: msgtext,
                        duration: 8000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#dc3545",
                    }).showToast();
                } else {
                    Toastify({
                        text: msgtext,
                        duration: 8000,
                        close:true,
                        gravity:"top",
                        position: "right",
                        backgroundColor: "#dc3545",
                    }).showToast();
                }
            }
        })
    })


    uppy.on('complete', (result) => {
        console.log('Upload complete! Weve uploaded these files:', result.successful)
    })

    uppy.on('upload-success', (file, response) => {
        const url = response.uploadURL;
        const fileName = file.name;
        const routeDelete = params.urldelete + response.body.last_insert_id;
        // console.log(routeDelete);

        const div = document.createElement('div');

        div.className = 'col-md-6';
        div.id = 'gallery-' + response.body.last_insert_id
        div.innerHTML = `
            <div class="card m-b-24">
                <div class="card-content card-img-top card-img-bottom">
                    <img src="` + url + `" class="card-img-top card-img-bottom img-uppy" alt="` + fileName + `">
                    <button type="button" class="btn btn-WHITE100 uppy-button-delete" data-url="` + routeDelete + `">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.25 5.25L6.1875 20.25C6.23203 21.1167 6.8625 21.75 7.6875 21.75H16.3125C17.1408 21.75 17.7595 21.1167 17.8125 20.25L18.75 5.25" stroke="#FF0000" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.75 5.25H20.25H3.75Z" fill="#FF0000"/>
                            <path d="M3.75 5.25H20.25" stroke="#FF0000" stroke-miterlimit="10" stroke-linecap="round"/>
                            <path d="M9 5.25V3.375C8.99957 3.22715 9.02837 3.08066 9.08475 2.94397C9.14114 2.80729 9.22399 2.6831 9.32854 2.57854C9.43309 2.47399 9.55728 2.39114 9.69397 2.33476C9.83066 2.27838 9.97714 2.24957 10.125 2.25H13.875C14.0229 2.24957 14.1693 2.27838 14.306 2.33476C14.4427 2.39114 14.5669 2.47399 14.6715 2.57854C14.776 2.6831 14.8589 2.80729 14.9152 2.94397C14.9716 3.08066 15.0004 3.22715 15 3.375V5.25M12 8.25001V18.75M8.625 8.25001L9 18.75M15.375 8.25001L15 18.75" stroke="#FF0000" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <input type="hidden" name="storageid[]" value="` + response.body.last_insert_id + `">
                </div>
            </div>`;

        var d = document.getElementById("section-uploaded-files");
        d.appendChild(div);
        
        var gi = document.getElementById("gallery_img");
        gi.setAttribute('value' , 1);

    })
}

$(document).on('click', '.uppy-button-delete', function (ev) {
    let url = $(this).data('url');
    alertify
        .okBtn("Delete")
        .cancelBtn("Cancel")
        .confirm("Are you sure to delete this data?", function (ev) {
            ev.preventDefault();
            deleteDataStorage(url);
        }, function (ev) {
            ev.preventDefault();
        });
});

function deleteDataStorage(data) {
    $.ajax({
        url: data,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    .done(function (response) {

        $('#' + 'gallery-' + response.id).remove();

        var g = document.querySelectorAll('#section-uploaded-files .uppy-button-delete').length;
        if (g > 0) {
            tg = 1;
        } else {
            tg = 0;
        }

        var d = document.getElementById("gallery_img");
        d.setAttribute('value' , tg);

        console.log(g);
        console.log(tg);
        console.log(response.id);
        
    })
    .fail(function (jqXHR, response) {
        console.log(response);
    })
} 