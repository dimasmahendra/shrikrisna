@php
    $title = "Dashboard Admin";
    $breadcrumbs[] = ["label" => "Dashboard Admin", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card"></div>
@endsection

@push('js-plugins')

@endpush