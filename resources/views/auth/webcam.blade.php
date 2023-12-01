<!DOCTYPE html>
<html>
<head>
    <title>FOTO FOTO</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results { 
            padding:20px; 
            border:1px solid; 
            background:#ccc; 
        }

        #fotoImg {
            width: 98%;		
        }

        .image-input {
            text-align: center;
        }
        .image-input input {
            display: none;
        }
        .image-input label {
            display: block;
            color: #FFF;
            background: #000;
            padding: 0.3rem 0.6rem;
            font-size: 115%;
            cursor: pointer;
        }
        .image-input label i {
            font-size: 125%;
            margin-right: 0.3rem;
        }
        .image-input label:hover i {
            animation: shake 0.35s;
        }
        .image-input img {
            max-width: 175px;
            display: none;
        }
        .image-input span {
            display: none;
            text-align: center;
            cursor: pointer;
        }

        @keyframes shake {
            0% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(10deg);
            }
            50% {
                transform: rotate(0deg);
            }
            75% {
                transform: rotate(-10deg);
            }
            100% {
                transform: rotate(0deg);
            }
        }
    </style>
</head>
<body>
    
<div class="container">
    <h1 class="text-center">FOTO FOTO</h1>
     
    <form method="POST" action="{{ route('webcam.capture') }}">
        @csrf
        <div class="col-md-12">
            <div id="results">
                <center><img id="fotoImg" style="visibility: hidden;"></center>
            </div>
        </div>
        <div class="col-md-12">
            <div id="my_camera"></div>
            <br/>
            <div class="image-input">
                <input type=file id="imageInput" name="image" accept="image/*" capture>
                <label for="imageInput" class="image-button"><i class="far fa-image"></i> Take A Selfie </label>
            </div>
        </div>        
        <div class="col-md-12 text-center">
            <br/>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
</div>
    
<script language="JavaScript">

    oFReader = new FileReader();
	
    oFReader.onload = function (oFREvent) {

        document.getElementById("fotoImg").src = oFREvent.target.result;
        document.getElementById("fotoImg").style.visibility = "visible"; 
        var screenHeight = screen.availHeight;
        screenHeight = screenHeight - 220;
        document.getElementById("fotoImg").style.height = screenHeight;
    };
    
    $(function() {
        $("input:file").change(function (){
            var input = document.querySelector('input[type=file]');
            var oFile = input.files[0];
            oFReader.readAsDataURL(oFile);
        });
    });

</script>
   
</body>
</html>