@php
    $title = "Customer";
    $breadcrumbs[] = ["label" => "Edit Customer", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <form action="{{ route('customer.update', [$data->id]) }}" method="POST" enctype="multipart/form-data" id="formcreate">
        {{ csrf_field() }}
        <div class="section-header">
            <div class="section-subitem-start">
                <div class="text-item-start">
                    <a href="{{ route('customer.details', [$data->id]) }}" class="fs-14">Cancel</a>
                </div>
            </div>
            <div class="p-l-10 p-r-10">
                <div class="text-item">Edit Customer</div>
            </div>
            <div class="section-subitem-end">
                <div class="text-item-end">
                    <button type="submit" class="btn btn-outline-primary fs-14 p-r-unset">Done</button>
                </div>
            </div>
        </div>
        <div>
            <div class="section-image-user">
                <div class="section-image m-b-6">
                    <input type="file" name="photo" accept="image/*" class="dropify" 
                    data-show-remove="false" data-max-file-size="50M" id="profile_image" data-height="200"
                    data-default-file="{{ $data->image_url }}" />
                    <div class="invalid-feedback invalid-image"></div>          
                </div>
                <button type="button" class="btn btn-outline-primary w-150 h-45" id="buttonupload">Edit Photo</button>
            </div>
        </div>
        <div class="bg-NEUTRAL10 p-t-20">        
            <div class="row">
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <div>
                            <input type="text" id="nomor_ktp" class="form-control" name="nomor_ktp" 
                            placeholder="No ID" value="{{ $data->nomor_ktp }}">
                        </div>
                        <div>
                            <input type="text" id="name" class="form-control" name="name" 
                            placeholder="Full Name" value="{{ $data->name }}">
                        </div>
                        <div>
                            <input type="text" id="phone_number" class="form-control" name="phone_number" 
                            placeholder="Phone No" value="{{ $data->phone_number }}">
                        </div>
                        <div>
                            <input type="text" id="institution" class="form-control" name="institution" 
                            placeholder="Institution" value="{{ $data->institution }}">
                        </div>
                        <div>
                            <input type="text" id="email" class="form-control" name="email" 
                            placeholder="Email" value="{{ $data->email }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <textarea id="address" class="form-textarea" 
                        placeholder="Address" rows="6" name="address">{{ $data->address }}</textarea>
                    </div>
                </div>
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <textarea id="notes" class="form-textarea" 
                        placeholder="Notes" rows="6" name="notes">{{ $data->notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if (Auth::user()->id_role == 1)
        <div class="row">
            <div class="col-md-12 p-r-unset">
                <button type="button" class="btn btn-WHITE100-red h-40 button-destroy w-100persen text-left"
                    data-url="{{ route('customer.destroy',[$data->id]) }}">
                    Delete
                </button>
            </div>
        </div>
    @endif
</div>
@endsection

@push('css-plugins')
<link rel="preload" href="/cms/css/pages/customer-create.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/pages/customer-create.css?v={{ $version }}">
</noscript>
<link rel="preload" href="/cms/vendors/dropify/dist/css/dropify.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/vendors/dropify/dist/css/dropify.css?v={{ $version }}">
</noscript>
@endpush

@push('js-plugins')
<script src="/cms/vendors/dropify/dist/js/dropify.js?v={{ $version }}"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $(document).ready(function() {
                $('#profile_image').dropify({
                    tpl: {
                        wrap: '<div class="dropify-wrapper" id="profile_wrapper"></div>',
                    }
                });

                $("#formcreate").validate({
                    errorClass: 'was-validated',
                    rules : {
                        name : {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "This field is Required",
                        },
                    },
                    success: function (error) {
                        error.remove();
                    },
                    submitHandler: function (form) {
                        $("body").addClass("loading");
                        let myForm = $('#formcreate')[0];
                        myForm.submit();
                    }
                });
            });

            $(document).on('click', '#buttonupload', function() {
                $("#profile_image").click();
            });
        })(jQuery);
    });
</script>
@endpush