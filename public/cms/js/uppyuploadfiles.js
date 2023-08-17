function uppyUploadFiles(params) {

    console.log(params);

    const { XHRUpload, FileInput, ProgressBar } = Uppy
    const fileInput = document.querySelector(params.fileinput)

    var uppy = new Uppy.Core({ 
            debug: true, 
            autoProceed: true,
            restrictions: {
                maxFileSize: 2097152,
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
            fieldName: 'image',
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
                uppy.addFile({
                    source: 'file input',
                    name: file.name,
                    type: file.type,
                    data: file,
                })
            } catch (err) {
                msgtext = "File : " + file.name + " <br /> " + err;
                console.log(msgtext);
                if (err.isRestriction) {
                    // console.log('Filename:', file.name)
                    // console.log('Restriction error:', err)
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
                    <button type="button" class="btn btn-danger w-100px h-30 uppy-button-delete" data-url="` + routeDelete + `">Delete</button>
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