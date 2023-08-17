@php
    if (request()->query("filter") == "active") {
        $dropdownText = "Publish";
    } elseif (request()->query("filter") == "nonactive") {
        $dropdownText = "Not Publish";
    } else {
        $dropdownText = "Status";
    }
@endphp
<div class="dropdown">
    <button class="w-125 h-40 m-l-10 btn btn-filter dropdown-toggle form-select-filter button-resized" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ $dropdownText }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item text-success" href="{{ $route }}?filter=active">Publish</a>
        <a class="dropdown-item text-danger" href="{{ $route }}?filter=nonactive">Not Publish</a>
    </div>
</div>