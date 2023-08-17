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
        <div class="w-125"></div>
        <div class="w-125 p-l-10 p-r-10">
            <div class="text-item">Customer</div>
        </div>
        <div class="w-125 section-subitem">
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
                            <tr data-id="{{ $item->id }}">
                                <td class="d-none">{{ mb_substr(ucfirst($item->name), 0, 1); }}</td>
                                <td>
                                    <p class="m-b-5">{{ $item->name }}</p>
                                    <p class="m-b-5">{{ $item->nomor_ktp }}</p>
                                    <p class="m-b-5 text-PRIMARY60">{{ $item->phone_number }}</p>
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
    <link href="/cms/css/pages/customer.css?v={{ $version }}" rel="stylesheet">
    <style>
        a {
            color: #006EE9;
            text-decoration: none;
        }

        td:hover {
            background-color: #F1F1F1;
            cursor: pointer;
        }
    </style>
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datatable/js/dataTables.rowGroup.min.js"></script>
<script>
    $(document).ready(function() {
        var editUrl = "{{ route('customer.edit', ':id') }}"
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
            "order": [[ 0, "asc" ]],
        });

        table.on('click', 'tbody td', function(item) {
            var id = $(this.parentNode).data('id');
            url = editUrl.replace(':id', id);
            window.location.href = url;
        })
    });
</script>
@endpush