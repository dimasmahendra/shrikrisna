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
            rotateImage(data_uri, 180, (url) => {
                $(".image-tag").val(url);
                document.getElementById('results').innerHTML = '<img src="'+url+'"/>';
            });
        } );
    }

    rotateImage = (imageBase64, rotation, cb) => {
        var img = new Image();
        img.src = imageBase64;
        img.onload = () => {
            var canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;
            var ctx = canvas.getContext("2d");
            ctx.setTransform(1, 0, 0, 1, img.width / 2, img.height / 2);
            ctx.rotate(rotation * (Math.PI / 180));
            ctx.drawImage(img, -img.width / 2, -img.height / 2);
            cb(canvas.toDataURL("image/jpeg", 1))
        };
    };
</script>
   
</body>
</html>