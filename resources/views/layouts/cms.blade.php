<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta-custom')
    
    <title>{{isset($title) ? $title : ""}} | Shrikrisna</title>
    <link rel="shortcut icon" href="{{ $faviconcompany }}" type="image/x-icon">
    @include("layouts.head")
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
    <script src="/cms/vendors/jquery/jquery.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/jquery.dataTables.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/vendors/bootstrap-datatable/js/dataTables.bootstrap.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/js/bootstrap.bundle.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/vendors/jquery-validate/jquery-validate.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/vendors/toastify/toastify.js?v={{ Str::random(7) }}"></script>
    @stack('js-plugins')
    <script src="/cms/js/change-password.min.js?v={{ Str::random(7) }}"></script>
    <script src="/cms/js/cms.min.js?v={{ Str::random(7) }}"></script>
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
