<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Shrikrisna</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ $faviconcompany }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/cms/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/cms/vendors/toastify/toastify.css">
    <link rel="stylesheet" type="text/css" href="/auth/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/cms/css/util.css?v={{ $version }}">
    <link rel="stylesheet" type="text/css" href="/fontello/css/fontello.css?v={{ $version }}">
    <link rel="stylesheet" type="text/css" href="/cms/css/color-base-1.0.1.css">
    <link rel="stylesheet" type="text/css" href="/auth/css/style.css?v={{ $version }}">
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('auth/img/img-auth.png');"></div>
        <div class="contents order-2 order-md-1">
            @yield('content')
        </div>
    </div>
    <script src="{{ '/auth/js/jquery-3.3.1.min.js' }}"></script>
    <script src="{{ '/cms/vendors/toastify/toastify.js' }}"></script>
    <script src="{{ '/auth/js/main.js' }}"></script>
    @if(Session::has('success'))
    <script>
        Toastify({
            text: "<?=Session::get('success')?>",
            duration: 4000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#4fbe87",
        }).showToast();
    </script>
    @endif
    @if(Session::has('errors'))
    <script>
        Toastify({
            text: "<?=Session::get('errors')?>",
            duration: 4000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc3545",
        }).showToast();
    </script>
    @endif
</body>

</html>