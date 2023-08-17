@php
    $title = "Role Management";
    $breadcrumbs[] = ["label" => "Role Management", "url" => "#"];
@endphp

@extends('layouts.cms', [
    "title" => $title,
    "breadcrumbs" => $breadcrumbs,
])

@section('content')
<div class="card">
    <div class="row">
        <div class="col-md-3 gy-3">
            <form action="{{ route('rbac.role.index') }}" method="get">
                <div class="input-group">
                    <input class="form-control border-end-0" type="search" value="{{ (request()->query("search") != "") ? request()->query("search") : '' }}" id="search-input" name="search" placeholder="Search">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary bg-white border-start-1 border-bottom-1 h-40" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <div class="col-md-9 gy-3 d-flex justify-content-end">
            @include('components.filter', ['route' => route('rbac.role.index')])
            @if ($auth_permission['rbac.role.create'])
                <a href="{{ route('rbac.role.create') }}">
                    <button class="btn btn-secondary m-l-10 float-end h-40 w-125 open-modal" type="button">Add Data</button>
                </a>
            @endif
        </div>
    </div>
    <div class="card-body-list">
        @if (count($role) > 0)
            <div class="table-responsive">
                <table class="table" id="filterTable" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-left">Role Name</th>
                            <th class="text-left">Status</th>
                            @if ($auth_permission['rbac.role.edit'] || $auth_permission['rbac.role.destroy'])
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($role as $key => $item)
                            <tr>
                                <td width="40%">{{ $item->role_name }}</td>
                                <td width="30%">
                                    @if ($item->status == 'active')
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Not Active</span>
                                    @endif
                                </td>
                                @if ($auth_permission['rbac.role.edit'] || $auth_permission['rbac.role.destroy'])
                                    <td class="text-center">
                                        @if ($auth_permission['rbac.role.edit'])
                                            <a href="{{ route('rbac.role.edit', [$item->id]) }}">
                                                <button type="button" class="btn btn-primary btn-width me-2 master-edit">Update</button>
                                            </a>
                                        @endif
                                        @if ($auth_permission['rbac.role.destroy'])
                                            @if ($item->id != 1)
                                                <button type="button" class="btn btn-danger btn-width button-destroy"
                                                    data-url="{{ route('rbac.role.destroy',[$item->id]) }}">
                                                    Delete
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 mt-40 mb-60 text-right animate-box" data-animate-effect="fadeInUp">
                    <!-- Pagination -->
                    {{ $role->links('components.paginator') }}
                </div>
            </div>
        @else
            <div class="item-center text-center text-data-not-found">
                <img src="{{ '/cms/images/logo/data-not-found.png' }}" alt="Data Not Found" class="mx-auto d-block h-99 w-121 m-b-5">
                No Data Found
            </div>
        @endif
    </div>
</div>
@endsection

@push('js-plugins')
<script>
    let baseUrl = "{{ route('rbac.role.index') }}";
</script>
@endpush