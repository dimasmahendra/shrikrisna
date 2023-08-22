@php
    $page = URL::current();
@endphp

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item {{ (strpos($page, 'customer') !== false) ? 'active' : '' }} ">
                    <a href="{{ route('customer.index') }}" class='sidebar-link p-t-20 p-b-20'>
                        <i class="icon-customer fs-20"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li class="sidebar-item {{ (strpos($page, 'users') !== false) ? 'active' : '' }} ">
                    <a href="{{ route('rbac.users.index') }}" class='sidebar-link p-t-20 p-b-20'>
                        <i class="icon-user fs-20"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="sidebar-item {{ (strpos($page, 'category') !== false) ? 'active' : '' }} ">
                    <a href="{{ route('category.index') }}" class='sidebar-link p-t-20 p-b-20'>
                        <i class="icon-gear fs-20"></i>
                        <span>Category</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>