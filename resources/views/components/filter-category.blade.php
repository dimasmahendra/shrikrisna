@php
    $selected = request()->query("c");
    if ($selected != null) {
        $first = array_column($category->toArray(), null, 'id');
        $dropdownText = $first[$selected]['category_name'];
    } else {
        $dropdownText = "Category";
    }

@endphp
<div class="dropdown">
    <button class="w-160 h-40 btn btn-very-danger dropdown-toggle form-select-filter button-resized text-elipsis" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ $dropdownText }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach ($category as $catitem)
            <a class="dropdown-item" href="{{ $route }}?c={{ $catitem->id }}">{{ $catitem->category_name }}</a>
        @endforeach
    </div>
</div>