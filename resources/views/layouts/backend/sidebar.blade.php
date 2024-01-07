<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('backend.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('backend.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.file-manager') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Media Manager</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.banner.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Banner</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Shop
    </div>

    <!-- Categories -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.category.index') }}">
            <i class="fas fa-sitemap"></i>
            <span>Categories</span>
        </a>
    </li>
    {{-- Products --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.product.index') }}">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
    </li>

    {{-- Brands --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.brand.index') }}">
            <i class="fas fa-tags"></i>
            <span>Brands</span>
        </a>
    </li>

    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.order.index') }}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders</span>
        </a>
    </li>

    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.review.index') }}">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.coupon.index') }}">
            <i class="fas fa-table"></i>
            <span>Coupon</span></a>
    </li>
    <!-- Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>
    <!-- General settings -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('backend.settings') }}">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
