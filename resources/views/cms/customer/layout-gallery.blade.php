<a data-lg-size="1400-1400" class="d-flex gallery-item col-md-4 p-l-2 p-r-2 p-b-4"
    data-src="{{ $item->url_path }}"
    data-sub-html="<p> {{ $item->created_at }} - {{ $item->customer->name }}</p>">
    <img class="img-fluid" src="{{ $item->url_path }}" />
</a>