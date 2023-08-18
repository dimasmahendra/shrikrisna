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
            <div class="avatar avatar-mdx me-3 d-md-none-custom">
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
                            <tr data-id="{{ $item->id }}">
                                <td class="d-none">{{ mb_substr(ucfirst($item->name), 0, 1); }}</td>
                                <td>
                                    <div class="m-b-5">{{ $item->name }}</div>
                                    <div class="m-b-5 text-SECONDARY60 fs-12">{{ $item->nomor_ktp }}</div>
                                    <p class="m-b-5 text-PRIMARY60 fs-12">{{ $item->phone_number }}</p>
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

        table.dataTable {
            margin-bottom: 0px !important;
        }

        @media (min-width: 1199px) {
            .d-md-none-custom {
                display: none !important;
            }
        }
    </style>
@endpush

@push('js-plugins')
<script src="/cms/vendors/bootstrap-datatable/js/dataTables.rowGroup.min.js"></script>
<script>
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

        table.on('click', 'tbody td', function(item) {
            var id = $(this.parentNode).data('id');
            url = editUrl.replace(':id', id);
            window.location.href = url;
        })
    });
</script>
@endpush