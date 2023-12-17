@php
    $title = "Customer";
    $breadcrumbs[] = ["label" => "Customer", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="section-header">
        <div class="section-subitem">
            <div class="avatar avatar-mdx d-md-none-custom">
                <img src="{{ Auth::user()->gambar_url }}" alt="" class="object-fit-cover">                               
            </div>
        </div>
        <div class="p-l-10 p-r-10">
            <div class="text-item">Customer</div>
        </div>
        <div class="section-subitem">
            <div class="text-item-end">
                <a href="{{ route('customer.create') }}">Add</a>
            </div>
        </div>
    </div>
    <div>
        @if (count($data) > 0)
            <div class="table-responsive">
                <table class="table" id="filterTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-left fw-600 d-none">First Letter</th>
                            <th class="text-left fw-600 d-none">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="d-none">{{ mb_substr(ucfirst($item->name), 0, 1); }}</td>
                                <td>
                                    <div class="d-flex justify-content-between" data-id="{{ $item->id }}">
                                        <div class="col-md-8 customer_info" style="flex: 1 0 auto;">
                                            <div class="m-b-5">{{ $item->name }}</div>
                                            <div class="m-b-5 text-SECONDARY60 fs-12">{{ $item->nomor_ktp }}</div>
                                            <p class="m-b-5 text-PRIMARY60 fs-12">{{ $item->phone_number }}</p>
                                            <p class="m-b-5 text-PRIMARY60 fs-12">{{ $item->institution }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{{ route('customer.edit', [$item->id]) }}">
                                                <i class="icon-pencil fs-17"></i>
                                            </a>
                                            <button type="button" class="btn btn-WHITE100-red button-destroy"
                                                data-url="{{ route('customer.destroy',[$item->id]) }}">
                                                <i class="icon-bin fs-20" style="color: #E82623;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-data-not-found">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                No Data Found
            </div>
        @endif
    </div>
</div>
@endsection

@push('css-plugins')
<link rel="preload" href="/cms/css/pages/customer.css?v={{ $version }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" type="text/css" href="/cms/css/pages/customer.css?v={{ $version }}">
</noscript>
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datatable/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        (function($) {
            $(document).ready(function() {
            var editUrl = "{{ route('customer.details', ':id') }}";
            var table = $("#filterTable").DataTable({
                "ordering": true,
                "bPaginate": false,
                "searching": true,
                "lengthChange": false,
                "info": false,
                "dom": "<'row'<'col-sm-12 col-md-12'f>>" +
                    "<'row'<'col-sm-12 m-t-0'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "rowGroup": {
                    "dataSrc": 0
                },
                "language": {
                    "info": "",
                    "searchPlaceholder": "Search",
                    "search": "",
                },
                "order": [[ 1, "asc" ]],
            });

            $('div.dataTables_filter input', table.table().container()).focus();

            table.on('click', 'tbody td div > .customer_info', function(item) {
                var id = $(this.parentNode).data('id');
                url = editUrl.replace(':id', id);
                window.location.href = url;
            })
        })
        })(jQuery);
    });
</script>
@endpush