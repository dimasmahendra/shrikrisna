@php
    if (request()->query("filter") == "active") {
        $dropdownText = "Active";
    } elseif (request()->query("filter") == "nonactive") {
        $dropdownText = "Not Active";
    } else {
        $dropdownText = "All Status";
    }
@endphp
<div class="dropdown">
    <button class="w-150 h-45 m-l-20 btn btn-PRIMARY60 dropdown-toggle form-select-filter fw-600" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ $dropdownText }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item {{ $dropdownText == 'All Status' ? 'active' : '' }}" href="{{ $route }}">All Status</a>
        <a class="dropdown-item text-success" href="{{ $route }}?filter=active">Active</a>
        <a class="dropdown-item text-danger" href="{{ $route }}?filter=nonactive">Not Active</a>
    </div>
</div>