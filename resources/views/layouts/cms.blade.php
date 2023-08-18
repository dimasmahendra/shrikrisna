<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta-custom')
    
    <title>{{isset($title) ? $title : ""}} | Shrikrisna</title>
    <link rel="shortcut icon" href="{{ $faviconcompany }}" type="image/x-icon">

    <link rel="stylesheet" href="/cms/css/google-font.css">
    <link rel="stylesheet" href="/cms/css/bootstrap.css">
    <link rel="stylesheet" href="/cms/vendors/bootstrap-datatable/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/cms/vendors/bootstrap-datatable/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="/cms/vendors/bootstrap-datatable/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="/cms/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/cms/vendors/toastify/toastify.css">
    <link rel="stylesheet" href="/cms/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/cms/css/app.css?v={{ $version }}">
    <link rel="stylesheet" href="/cms/css/util.css?v={{ $version }}">
    <link rel="stylesheet" href="/cms/css/cms.css?v={{ $version }}">
    <link rel="stylesheet" href="/fontello/css/fontello.css?v={{ $version }}">
    @stack('css-plugins')
</head>

<body>
    <div id="app">
        @include('components.sidebar')
        <div id="main" class='layout-navbar'>
            @include('components.topbar')
            <div id="main-content">
                <div class="page-heading">
                    <section class="section">
                        @yield('content')
                        @include('components.change-password')
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="/cms/vendors/jquery/jquery.min.js"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/dataTables.bootstrap.min.js"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/dataTables.fixedHeader.min.js"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/dataTables.responsive.min.js"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/responsive.bootstrap.min.js"></script>
    <script src="/cms/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/cms/vendors/alertify/js/alertify.js"></script>
    <script src="/cms/vendors/toastify/toastify.js"></script>
    <script src="/cms/js/bootstrap.bundle.min.js"></script>
    <script src="/cms/vendors/jquery-validate/jquery-validate.min.js"></script>
    @stack('js-plugins')
    <script src="/cms/js/change-password.js"></script>
    @if(Session::has('message'))
        <script>
            Toastify({
                text: "<?=Session::get('message')?>",
                duration: 4000,
                close:true,
                gravity: "top",
                position: "center",
                backgroundColor: "#4fbe87",
            }).showToast();
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            Toastify({
                text: "<?=Session::get('error')?>",
                duration: 4000,
                close:true,
                gravity: "top",
                position: "center",
                backgroundColor: "#dc3545",
            }).showToast();
        </script>
    @endif
</body>

</html>
