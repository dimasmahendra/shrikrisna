<link rel="preload" href="/cms/css/bootstrap.min.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/bootstrap.min.css?v={{ $version }}">
</noscript>

<link rel="preload" href="/cms/vendors/toastify/toastify.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/toastify/toastify.css">
</noscript>

<link rel="preload" as="font" href="/cms/vendors/bootstrap-icons/bootstrap-icons.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/bootstrap-icons/bootstrap-icons.css">
</noscript>

<link rel="preload" href="/cms/css/app.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/app.css?v={{ $version }}">
</noscript>

<link rel="preload" href="/cms/css/util.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/util.css?v={{ $version }}">
</noscript>

<link rel="preload" href="/cms/css/cms.min.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/cms.min.css?v={{ $version }}">
</noscript>

<link rel="preload" href="/fontello/css/fontello.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/fontello/css/fontello.css?v={{ $version }}">
</noscript>

@php
    $page = URL::current();
@endphp
@if (strpos($page, 'users') == false && strpos($page, 'category') == false)
    <link rel="preload" href="/cms/css/pages/customer-header.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" type="text/css" href="/cms/css/pages/customer-header.css?v={{ $version }}">
    </noscript>
@endif