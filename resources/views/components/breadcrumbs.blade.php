@php
    $items = (isset($breadcrumbs)) ? $breadcrumbs : [] ;
@endphp

<div class="row">
    <div class="col-12 col-md-12 order-md-2">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
                @foreach ($items as $item)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a class="link-danger" href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>