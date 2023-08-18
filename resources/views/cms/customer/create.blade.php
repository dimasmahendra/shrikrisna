@php
    $title = "Customer";
    $breadcrumbs[] = ["label" => "Add Customer", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div>
    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data" id="formcreate">
        {{ csrf_field() }}
        <div class="section-header">
            <div class="section-subitem-start">
                <div class="text-item-start">
                    <a href="{{ route('customer.index') }}">Cancel</a>
                </div>
            </div>
            <div class="p-l-10 p-r-10">
                <div class="text-item">New Customer</div>
            </div>
            <div class="section-subitem-end">
                <div class="text-item-end">
                    <button type="submit" class="btn btn-outline-primary fs-16 p-r-unset">Done</button>
                </div>
            </div>
        </div>
        <div>
            <div class="section-image-user">
                <div class="section-image m-b-6">
                    <input type="file" name="photo" accept="image/*" class="dropify" data-show-remove="false" data-max-file-size="2M" id="profile_image" data-height="175"
                    data-default-file="{{ url('cms/images/samples/no_user.png') }}" />
                    <div class="invalid-feedback invalid-image"></div>          
                </div>
                <button type="button" class="btn btn-outline-secondary w-150 h-45" id="buttonupload">Add Photo</button>
            </div>
        </div>
        <div class="bg-NEUTRAL10 p-t-20">        
            <div class="row">
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <div>
                            <input type="text" id="nomor_ktp" class="form-control" name="nomor_ktp" 
                            placeholder="No ID" value="{{ old('nomor_ktp') }}">
                        </div>
                        <div>
                            <input type="text" id="name" class="form-control" name="name" 
                            placeholder="Full Name" value="{{ old('name') }}">
                        </div>
                        <div>
                            <input type="text" id="phone_number" class="form-control" name="phone_number" 
                            placeholder="Phone No" value="{{ old('phone_number') }}">
                        </div>
                        <div>
                            <input type="text" id="institution" class="form-control" name="institution" 
                            placeholder="Institution" value="{{ old('institution') }}">
                        </div>
                        <div>
                            <input type="text" id="email" class="form-control" name="email" 
                            placeholder="Email" value="{{ old('email') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <textarea id="address" class="form-textarea" 
                        placeholder="Address" rows="6" name="address">{{ old('address') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6 p-r-unset">
                    <div class="m-b-25">
                        <textarea id="notes" class="form-textarea" 
                        placeholder="Notes" rows="6" name="notes">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('css-plugins')
<link href="/cms/css/pages/customer-create.css?v={{ $version }}" rel="stylesheet">
<link href="/cms/vendors/dropify/dist/css/dropify.css?v={{ $version }}" rel="stylesheet">
<style>
    .dropify-wrapper .dropify-preview {
        background-color: #9399A7 !important;
    }
</style>
@endpush

@push('js-plugins')
<script src="/cms/vendors/dropify/dist/js/dropify.min.js?v={{ $version }}"></script>
<script>
    $(document).ready(function() {
        $('#profile_image').dropify({
            tpl: {
                wrap: '<div class="dropify-wrapper" id="profile_wrapper"></div>',
            }
        });

        $("#formcreate").validate({
            errorClass: 'was-validated',
            rules : {
                photo : {
                    required: true,
                },
                nomor_ktp : {
                    required: true,
                },
                name : {
                    required: true,
                },
                phone_number : {
                    required: true,
                },
                institution : {
                    required: true,
                },
                address : {
                    required: true,
                },
                notes : {
                    required: true,
                },
            },
            messages: {
                photo: {
                    required: "This field is Required",
                },
                nomor_ktp: {
                    required: "This field is Required",
                },
                name: {
                    required: "This field is Required",
                },
                phone_number: {
                    required: "This field is Required",
                },
                institution: {
                    required: "This field is Required",
                },
                address: {
                    required: "This field is Required",
                },
                notes: {
                    required: "This field is Required",
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("id") == "profile_image") {
                    $("#profile_wrapper").addClass("border-invalid");                    
                } else {
                    error.insertAfter(element);
                }
            },
            success: function (error) {
                error.remove();
            },
            submitHandler: function (form) {
                let myForm = $('#formcreate')[0];
                myForm.submit();
            }
        });
    });

    $(document).on('click', '#buttonupload', function() {
        $("#profile_image").click();
    });
</script>
@endpush