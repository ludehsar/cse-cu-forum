<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo.png') }}" alt="CSE CU Forum" height="100">
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <router-link class="nav-link" to="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </router-link>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Management
    </div>

    <li class="nav-item">
        <router-link class="nav-link" to="/admin/users">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link class="nav-link" to="/admin/posts">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Posts</span>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link class="nav-link" to="/admin/categories">
            <i class="fas fa-fw fa-th"></i>
            <span>Categories</span>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link class="nav-link" to="/admin/tags">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tags</span>
        </router-link>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Report
    </div>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-bug"></i>
            <span>Reports</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->