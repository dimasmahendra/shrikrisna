<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>404 | Shrikrisna </title>
    <link rel="stylesheet" href="/cms/css/cms.css?v={{ $version }}">
    <link rel="stylesheet" href="/cms/css/bootstrap.css">
    <link rel="stylesheet" href="/cms/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/cms/css/app.css?v={{ $version }}">
    <link rel="stylesheet" href="/cms/css/pages/error.css?v={{ $version }}">
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <img class="img-error" src="/cms/images/samples/error-404.png" alt="Not Found">
                <div class="text-center">
                    <h1 class="error-title">NOT FOUND</h1>
                    <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
                    <a href="{{ url()->previous() }}" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
