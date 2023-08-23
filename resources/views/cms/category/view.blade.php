@php
    $title = "Detail Category Type";
    $breadcrumbs[] = ["label" => "Details Category", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title fs-20 fw-600 m-b-10">{{ $title }}</h4>
        <div class="col-md-4">
            <label class="text-PRIMARY100 p-b-4 fw-600 fs-14">Type Name</label>
        </div>
        <div class="fs-16">
            {{ ucwords($data->name) }}
        </div>
    </div>
    <div class="d-flex section-btn">
        <div class="col-md-6 d-flex"></div>
        <div class="col-md-6 d-flex"></div>
    </div>
    <div class="card-body-list">
        @if (count($details) > 0)
            <div class="table-responsive p-l-20">
                <table class="table" id="filterTable" style="width:98%">
                    <thead>
                        <tr>
                            <th class="text-left fw-600">Order</th>
                            <th class="text-left fw-600">Description</th>
                            <th class="text-left fw-600">Total Rows</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $key => $item)
                            <tr>
                                <td>{{ $item->order }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->total_rows }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 mt-40 mb-60 text-right animate-box" data-animate-effect="fadeInUp">
                    <!-- Pagination -->
                    {{ $details->links('components.paginator') }}
                </div>
            </div>
        @else
            <div class="text-center text-data-not-found">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                There was <span class="text-PRIMARY60">no Data Found</span>
            </div>
        @endif
    </div>
    <div class="p-t-20 p-b-20 custom-hr">
        <div>
            <a href="{{ route('category.details', [$data->id]) }}">
                <button type="button" class="btn btn-PRIMARY60 w-150 h-45 m-r-15 fw-600" id="button-update">Update</button>
            </a>
        </div>
    </div>
</div>
@endsection

@push('css-plugins')
<style>
    .section-btn {
        justify-content: space-between;
    }

    @media screen and (max-width: 1199px) {
        .p-l-40 {
            padding-left: 15px; 
        }
        img.logo-image {
            margin-left: 15px;
            margin-right: 50px;
        }

        .navbar-user-name {
            display: none !important;
        }

        .navbar-icon {
            margin: unset !important;
            display: inline-flex;
        }
    }
</style>
@endpush

@push('js-plugins')
<script>

    let baseUrl = "{{ route('category.details', [$data->id]) }}";

    $(document).ready(function () {
        $("#filterTable").dataTable({
            "ordering": true,
            "bPaginate": false,
            "searching": false,
            "lengthChange": false,
            "language": {
                "info": "",
            },
            "order": [[0, 'asc']],
            "columnDefs": [{
                targets: 'no-sort',
                orderable: false
            }],
        });
    });
</script>
@endpush