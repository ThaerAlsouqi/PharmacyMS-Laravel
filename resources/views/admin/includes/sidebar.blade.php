<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{ route_is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                </li>

                @can('view-category')
                    <li class="{{ route_is('categories.*') ? 'active' : '' }}">
                        <a href="{{ route('categories.index') }}"><i class="fas fa-th-large"></i>
                            <span>Categories</span></a>
                    </li>
                @endcan

                @can('view-purchase')
                    <li class="submenu {{ route_is('purchases.*') ? 'active' : '' }}">
                        <a href="#"><i class="fe fe-star-o"></i> <span> Purchase</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is('purchases.*') ? 'block' : 'none' }};">
                            <li><a class="{{ route_is('purchases.index') ? 'active' : '' }}"
                                    href="{{ route('purchases.index') }}">View Purchases</a></li>
                            @can('create-purchase')
                                <li><a class="{{ route_is('purchases.create') ? 'active' : '' }}"
                                        href="{{ route('purchases.create') }}">Add Purchase</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('view-products')
                    <li class="submenu {{ route_is(['products.*', 'outstock', 'expired']) ? 'active' : '' }}">
                        <a href="#"><i class="fe fe-document"></i> <span> Products</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is(['products.*', 'outstock', 'expired']) ? 'block' : 'none' }};">
                            <li><a class="{{ route_is('products.index') ? 'active' : '' }}"
                                    href="{{ route('products.index') }}">All Products</a></li>
                            @can('create-product')
                                <li><a class="{{ route_is('products.create') ? 'active' : '' }}"
                                        href="{{ route('products.create') }}">Add Product</a></li>
                            @endcan
                            @can('view-outstock-products')
                                <li><a class="{{ route_is('outstock') ? 'active' : '' }}" href="{{ route('outstock') }}">Out
                                        of Stock <span class="badge badge-danger">!</span></a></li>
                            @endcan
                            @can('view-expired-products')
                                <li><a class="{{ route_is('expired') ? 'active' : '' }}" href="{{ route('expired') }}">Expired
                                        <span class="badge badge-warning">!</span></a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

@can('view-sales')
                    <li class="{{ route_is('sales.create') ? 'active' : '' }}">
                        <a href="{{ route('sales.create') }}">
                            <i class="fas fa-cash-register"></i> 
                            <span>POS System</span>
                        </a>
                    </li>
                @endcan

                @can('view-invoices')
                    <li class="submenu {{ route_is('admin.invoices.*') ? 'active' : '' }}">
                        <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Invoices</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is('admin.invoices.*') ? 'block' : 'none' }};">
                            <li><a class="{{ route_is('admin.invoices.index') ? 'active' : '' }}"
                                    href="{{ route('admin.invoices.index') }}">All Invoices</a></li>
                        </ul>
                    </li>
                @endcan
                <li class="{{ route_is('barcode.*') ? 'active' : '' }}" title="Barcode Management">
                    <a href="{{ route('barcode.index') }}">
                        <i class="fas fa-barcode"></i>
                        <span>Barcodes</span>
                    </a>
                </li>
<!-- NEW: AI Demand Forecasting -->
<li class="{{ route_is('demand-forecast.*') ? 'active' : '' }}" title="AI Demand Forecasting">
    <a href="{{ route('demand-forecast.index') }}">
        <i class="fas fa-brain"></i>
        <span>AI Forecasting</span>
        <span class="badge badge-success">AI</span>
    </a>
</li>
                @can('view-supplier')
                    <li class="submenu {{ route_is('suppliers.*') ? 'active' : '' }}">
                        <a href="#"><i class="fe fe-user"></i> <span> Suppliers</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is('suppliers.*') ? 'block' : 'none' }};">
                            <li><a class="{{ route_is('suppliers.index') ? 'active' : '' }}"
                                    href="{{ route('suppliers.index') }}">All Suppliers</a></li>
                            @can('create-supplier')
                                <li><a class="{{ route_is('suppliers.create') ? 'active' : '' }}"
                                        href="{{ route('suppliers.create') }}">Add Supplier</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('view-reports')
                    <li class="submenu {{ route_is(['sales.report', 'purchases.report']) ? 'active' : '' }}">
                        <a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is(['sales.report', 'purchases.report']) ? 'block' : 'none' }};">
                            <li><a class="{{ route_is('sales.report') ? 'active' : '' }}"
                                    href="{{ route('sales.report') }}">Sales Report</a></li>
                            <li><a class="{{ route_is('purchases.report') ? 'active' : '' }}"
                                    href="{{ route('purchases.report') }}">Purchase Report</a></li>
                        </ul>
                    </li>
                @endcan

                @can('view-access-control')
                    <li class="submenu {{ route_is(['permissions.*', 'roles.*']) ? 'active' : '' }}">
                        <a href="#"><i class="fe fe-lock"></i> <span> Access Control</span> <span
                                class="fas fa-chevron-down"></span></a>
                        <ul style="display: {{ route_is(['permissions.*', 'roles.*']) ? 'block' : 'none' }};">
                            @can('view-permission')
                                <li><a class="{{ route_is('permissions.index') ? 'active' : '' }}"
                                        href="{{ route('permissions.index') }}">Permissions</a></li>
                            @endcan
                            @can('view-role')
                                <li><a class="{{ route_is('roles.*') ? 'active' : '' }}"
                                        href="{{ route('roles.index') }}">Roles</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <li class="menu-title">
                    <span>Settings</span>
                </li>

                @can('view-users')
                    <li class="{{ route_is('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"><i class="fas fa-users"></i> <span>Users</span></a>
                    </li>
                @endcan

                <li class="{{ route_is('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}"><i class="fas fa-user"></i> <span>My Profile</span></a>
                </li>

                {{-- <li class="{{ route_is('backup.index') ? 'active' : '' }}">
                    <a href="{{ route('backup.index') }}"><i class="fas fa-database"></i> <span>Backups</span></a>
                </li> --}}

                {{-- @can('view-settings')
                    <li class="{{ route_is('settings') ? 'active' : '' }}">
                        <a href="{{ route('settings') }}">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                @endcan --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

<style>
    /* Sidebar Improvements */
    .sidebar {
        background: #fff;
        border-right: 1px solid #f0f0f0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .sidebar-inner {
        position: relative;
        height: calc(100vh - 60px);
    }

    .sidebar-menu ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sidebar-menu>ul>li {
        position: relative;
    }

    .menu-title {
        padding: 20px 20px 10px;
        font-size: 11px;
        font-weight: 700;
        color: #8e8e93;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-menu>ul>li>a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        font-size: 14px;
        font-weight: 500;
    }

    .sidebar-menu>ul>li>a:hover {
        background: #f8f9fa;
        color: #667eea;
        padding-left: 25px;
    }

    .sidebar-menu>ul>li>a i {
        font-size: 16px;
        width: 20px;
        text-align: center;
        margin-right: 15px;
        color: #667eea;
    }

    .sidebar-menu>ul>li.active>a {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        border-radius: 10px;
        margin: 0 10px;
    }

    .sidebar-menu>ul>li.active>a i {
        color: white;
    }

    /* Submenu arrow styles */
    .submenu>a .fas.fa-chevron-down {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        transition: transform 0.3s ease;
        font-size: 12px;
        color: #8e8e93;
    }

    .submenu.active>a .fas.fa-chevron-down,
    .submenu>a[aria-expanded="true"] .fas.fa-chevron-down {
        transform: translateY(-50%) rotate(180deg);
    }

    .submenu ul {
        display: none;
        background: #f8f9fa !important;
        margin: 5px 10px;
        border-radius: 10px;
        padding: 10px 0;
        list-style: none !important;
    }

    .submenu ul li {
        list-style: none !important;
    }

    .submenu ul li a {
        display: block;
        padding: 10px 20px 10px 45px;
        color: #6c757d !important;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .submenu ul li a:hover {
        color: #667eea !important;
        padding-left: 50px;
        background: transparent !important;
    }

    .submenu ul li a.active {
        color: #667eea !important;
        font-weight: 600;
        background: transparent !important;
    }

    .submenu ul li a.active::before {
        content: "";
        position: absolute;
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: #667eea;
        border-radius: 50%;
    }

    /* Badges in sidebar */
    .sidebar-menu .badge {
        margin-left: 5px;
        font-size: 10px;
        padding: 2px 6px;
        font-weight: 600;
    }

    /* Active submenu parent */
    .submenu.active>a {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border-left: 3px solid #667eea;
    }

    /* Hover effects for submenu parent */
    .submenu>a:hover {
        background: #f8f9fa;
        color: #667eea;
    }

    /* Style for expanded submenu items */
    .sidebar .submenu ul {
        background: transparent !important;
    }

    .sidebar .submenu ul li {
        background: transparent !important;
    }

    .sidebar .submenu ul li a {
        background: transparent !important;
        color: #6c757d !important;
    }

    .sidebar .submenu ul li a:hover {
        background: rgba(102, 126, 234, 0.05) !important;
        color: #667eea !important;
    }

    /* Scrollbar styling */
    .slimScrollBar {
        background: #667eea !important;
        opacity: 0.4 !important;
        border-radius: 3px !important;
        width: 5px !important;
    }

    /* Material icons fix */
    .sidebar-menu i.material-icons {
        font-size: 20px;
    }

    /* Responsive sidebar */
    @media (max-width: 991.98px) {
        .sidebar {
            margin-left: -225px;
            transition: margin-left 0.3s ease;
        }

        .sidebar.opened {
            margin-left: 0;
        }
    }

    /* Mini sidebar styles */
    .mini-sidebar .sidebar-menu>ul>li>a span {
        display: none;
    }

    .mini-sidebar .sidebar-menu>ul>li>a {
        padding: 15px;
        justify-content: center;
    }

    .mini-sidebar .sidebar-menu>ul>li>a i {
        margin: 0;
        font-size: 22px;
    }

    .mini-sidebar .menu-title {
        display: none;
    }

    .mini-sidebar .submenu ul {
        position: absolute;
        left: 70px;
        top: 0;
        width: 200px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        background: white;
        border-radius: 10px;
    }

    /* Add this to the existing <style> section in sidebar.blade.php */

    /* MINIMAL COLLAPSIBLE SIDEBAR - PRESERVES YOUR ORIGINAL DESIGN */
    .sidebar {
        transition: width 0.3s ease;
        overflow: hidden;
    }

    .sidebar.collapsed {
        width: 70px;
    }

    /* Adjust main content when sidebar collapses */
    .main-wrapper.sidebar-collapsed .page-wrapper {
        margin-left: 70px;
    }

    /* Hide text in collapsed state */
    .sidebar.collapsed .sidebar-menu>ul>li>a span {
        display: none;
    }

    .sidebar.collapsed .sidebar-menu>ul>li>a {
        justify-content: center;
    }

    .sidebar.collapsed .sidebar-menu>ul>li>a i {
        margin: 0;
    }

    /* Hide menu titles when collapsed */
    .sidebar.collapsed .menu-title {
        display: none;
    }

    /* Simple tooltip on hover when collapsed */
    .sidebar.collapsed .sidebar-menu>ul>li:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 75px;
        top: 50%;
        transform: translateY(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1001;
    }

    /* Hide submenu arrows when collapsed */
    .sidebar.collapsed .submenu>a .fas.fa-chevron-down {
        display: none;
    }

    /* Show submenus on hover when collapsed */
    .sidebar.collapsed .submenu ul {
        position: absolute;
        left: 70px;
        top: 0;
        width: 200px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        z-index: 1002;
        display: none !important;
    }

    .sidebar.collapsed .submenu:hover ul {
        display: block !important;
    }

    /* Fix sidebar text visibility when expanded */
    .sidebar:not(.collapsed) .sidebar-menu>ul>li>a span {
        display: inline !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .sidebar:not(.collapsed) .sidebar-menu>ul>li>a {
        justify-content: flex-start !important;
    }

    .sidebar:not(.collapsed) .sidebar-menu>ul>li>a i {
        margin-right: 15px !important;
    }

    .sidebar:not(.collapsed) .menu-title {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* Responsive - hide sidebar on mobile */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .main-wrapper.sidebar-collapsed .page-wrapper {
            margin-left: 0;
        }
    }
</style>
