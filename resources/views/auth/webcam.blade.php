<!DOCTYPE html>
<html>
<head>
    <title>laravel webcam capture image and save from camera - CodeSolutionStuff</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }

        /* 
        CADANGAN ROTATE BY CSS
        #results {
            -webkit-transform: rotate(90deg); 
            -webkit-transform-origin: 50% 50%;
            transform: rotate(90deg); 
            transform-origin: 50% 50%;
        } */
    </style>
</head>
<body>
    
<div class="container">
    <h1 class="text-center">Laravel webcam capture image and save from camera - CodeSolutionStuff</h1>
     
    <form method="POST" action="{{ route('webcam.capture') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>
    
<script language="JavaScript">

    var database64 = 'data:image/jpeg;base64,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';

    Webcam.set({
        width: 490,
        height: 350,
        flip_horiz: false,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    
    Webcam.attach( '#my_camera' );
    
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            resetOrientation(data_uri, 7, function(resetBase64Image) {
                console.log(resetBase64Image);
                $(".image-tag").val(resetBase64Image);
                document.getElementById('results').innerHTML = '<img src="'+resetBase64Image+'"/>';
            });
        } );

        // rotateImage(data_uri, 180, (url) => {
        //     $(".image-tag").val(url);
        //     document.getElementById('results').innerHTML = '<img src="'+url+'"/>';
        // });

        // resetOrientation(database64, 5, function(resetBase64Image) {
        //     console.log(resetBase64Image);
        //     $(".image-tag").val(resetBase64Image);
        //     document.getElementById('results').innerHTML = '<img src="'+resetBase64Image+'"/>';
        // });

        // rotateImage(database64, 180, (url) => {
        //     $(".image-tag").val(url);
        //     document.getElementById('results').innerHTML = '<img src="'+url+'"/>';
        // });
    }

    function resetOrientation(srcBase64, srcOrientation, callback) {
        var img = new Image();

        img.onload = function () {
            var width = img.width,
                height = img.height,
                canvas = document.createElement('canvas'),
                ctx = canvas.getContext("2d");

            // set proper canvas dimensions before transform & export
            if (4 < srcOrientation && srcOrientation < 9) {
                canvas.width = height;
                canvas.height = width;
            } else {
                canvas.width = width;
                canvas.height = height;
            }

            // transform context before drawing image
            switch (srcOrientation) {
                case 2:
                    ctx.transform(-1, 0, 0, 1, width, 0);
                    break;
                case 3:
                    ctx.transform(-1, 0, 0, -1, width, height);
                    break;
                case 4:
                    ctx.transform(1, 0, 0, -1, 0, height);
                    break;
                case 5:
                    ctx.transform(0, 1, 1, 0, 0, 0);
                    break;
                case 6:
                    ctx.transform(0, 1, -1, 0, height, 0);
                    break;
                case 7:
                    ctx.transform(0, -1, -1, 0, height, width);
                    break;
                case 8:
                    ctx.transform(0, -1, 1, 0, 0, width);
                    break;
                default:
                    break;
            }

            // draw image
            ctx.drawImage(img, 0, 0);

            // export base64
            callback(canvas.toDataURL());
        };

        img.src = srcBase64;
    }

    // rotateImage = (imageBase64, rotation, cb) => {
    //     var img = new Image();
    //     img.src = imageBase64;
    //     img.onload = () => {
    //         var canvas = document.createElement("canvas");
    //         canvas.width = img.width;
    //         canvas.height = img.height;
    //         var ctx = canvas.getContext("2d");
    //         ctx.setTransform(1, 0, 0, 1, img.width / 2, img.height / 2);
    //         ctx.rotate(rotation * (Math.PI / 180));
    //         ctx.drawImage(img, -img.width / 2, -img.height / 2);
    //         cb(canvas.toDataURL("image/jpeg", 1))
    //     };
    // };

    // rotateImage = (imageBase64, rotation, cb) => {
    //     var img = new Image();
    //     img.src = imageBase64;
    //     img.onload = () => {
    //         var canvas = document.createElement("canvas");
    //         canvas.width = img.width;
    //         canvas.height = img.height;
    //         var ctx = canvas.getContext("2d");
    //         ctx.translate(img.width / 2, img.height / 2);
    //         ctx.rotate(rotation * (Math.PI / 180));
    //         ctx.translate(-img.width / 2, -img.height / 2);
    //         ctx.drawImage(img, 0, 0);
    //         cb(canvas.toDataURL("image/jpeg", 1))
    //     };
    // };
</script>
   
</body>
</html>