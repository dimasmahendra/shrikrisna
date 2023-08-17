@php
    $title = "Create Role";
    $breadcrumbs[] = ["label" => "Create Role", "url" => route('rbac.role.index')];
    $breadcrumbs[] = ["label" => "Create Role", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs
])

@section('content')
<div class="card">
    <div class="card-body px-4 border rounded-4">
        <form action="{{ route('rbac.role.store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <input type="hidden" id="access_control_count" name="access_control_count" value="0">
                <div class="col-md-8">
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Role Name</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="role_name" class="form-control @error('role_name') is-invalid @enderror" name="role_name" 
                            placeholder="Input Role Name" value="{{ old('role_name') }}" required>
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Status</label>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input w-30 h-30" type="radio" name="status" id="status1" value="active" checked>
                                <label class="form-check-label m-t-6 m-l-10" for="status1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input w-30 h-30" type="radio" name="status" id="status2" value="nonactive">
                                <label class="form-check-label m-t-6 m-l-10" for="status2">Not Active</label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="pb-2">
                        <div class="col-md-4">
                            <label class="text-label pb-2"><span class="text-danger">*</span> Access Control</label>
                        </div>
                        @if (count($access) > 0)
                            @foreach ($access as $key => $subitem)
                                <div class="col-md-12 m-b-25">
                                    <div class="list-group custom-shadow-1">
                                        <div class="list-group-item bg-brownis">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                        <div class="row custom-list-item">
                                            @foreach ($subitem as $index => $item)
                                                <div class="{{ ($key == 'settings') ? 'col-md-4' : 'col-md-3'  }} form-check form-switch m-t-10">
                                                    <input type="hidden" name="permission[{{ $item['route_name'] }}]" value="false">
                                                    <input class="form-check-input h-30 w-51 custom-switch {{ ($index == 0) ? 'view_checkbox' :  $key }}" type="checkbox" 
                                                    {{ ($index == 0) ? '' : 'disabled' }}
                                                    name="permission[{{ $item['route_name'] }}]" value="true"  {{ ($index == 0) ? "data-switch=" . $key : '' }}>
                                                    <label class="form-check-label m-t-6 m-l-11">{{ ucwords($item['text']) }}</label>
                                                </div> 
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="item-center text-center text-data-not-found">
                                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                                No Data Found
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="m-t-31">
                        <button type="submit" class="btn btn-secondary w-125 h-40">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css-plugins')
    
@endpush

@push('js-plugins')
<script>
    $(document).ready(function() {
        countCheckbox();
    });

    $(document).on('change', '.view_checkbox', function() {
        countCheckbox();
        var id = $(this).data('switch');
        var element = $(this).closest('.custom-list-item').find('.' + id);
        element.prop('disabled', !this.checked);
        if (!this.checked) {
            element.prop('checked', false);
        }
    });

    function countCheckbox() {
        var numberOfChecked = $('input:checkbox:checked').length;
        // var totalCheckboxes = $('input:checkbox').length;
        // var numberNotChecked = totalCheckboxes - numberOfChecked;

        $("#access_control_count").val(numberOfChecked);
        return numberOfChecked;
    }
</script>
@endpush