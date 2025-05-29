<!-- Header -->
<div class="header">
    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="@if (!empty(AppSettings::get('logo'))) {{ asset('storage/' . AppSettings::get('logo')) }} @else{{ asset('assets/img/logo2.jpg') }} @endif"
                alt="Logo" class="logo-img">
            <span class="logo-text">PHARMACY</span>
        </a>
        <a href="{{ route('dashboard') }}" class="logo logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="Logo" width="30" height="30">
        </a>
    </div>
    <!-- /Logo -->

    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->

    <!-- Header Right Menu -->
    <ul class="nav user-menu">
        <!-- Quick POS Access -->
        <li class="nav-item">
            <a href="{{ route('sales.create') }}" title="Quick POS Access" class="nav-link header-action-btn quick-pos-btn">
                <i class="fas fa-cash-register"></i>
                <span class="badge badge-success badge-pill">POS</span>
            </a>
        </li>

        <!-- Quick Invoice Access -->
        <li class="nav-item">
            <a href="{{ route('admin.invoices.index') }}" title="View Invoices" class="nav-link header-action-btn">
                <i class="fas fa-file-invoice-dollar"></i>
            </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link header-action-btn" data-toggle="dropdown">
                <i class="fe fe-bell"></i>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-pill notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="{{ route('notifications.markAllAsRead') }}" class="clear-noti">Mark All As Read</a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="notification-message">
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}">
                                    <div class="media">
                                        <span class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle" alt="Product image"
                                                src="{{ isset($notification->data['image'])
                                                    ? asset('storage/purchases/' . $notification->data['image'])
                                                    : asset('assets/img/default-product.png') }}">
                                        </span>
                                        <div class="media-body">
                                            <h6 class="notification-title @if ($notification->data['title'] == 'Expired Product Alert') text-danger @else text-warning @endif">
                                                {{ $notification->data['title'] }}
                                            </h6>
                                            <p class="noti-details">
                                                @if ($notification->data['title'] == 'Expired Product Alert')
                                                    <span class="noti-title">{{ $notification->data['product_name'] }}
                                                        has expired</span>
                                                @else
                                                    <span class="noti-title">
                                                        {{ $notification->data['product_name'] }}
                                                        ({{ $notification->data['quantity'] }}/{{ $notification->data['minimum_stock'] }})
                                                    </span>
                                                @endif
                                            </p>
                                            <p class="noti-time">
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="notification-message text-center p-4">
                                <div class="empty-notifications">
                                    <i class="fe fe-bell-off"></i>
                                    <p class="mb-0 text-muted">No new notifications</p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="#">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow user-dropdown">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle"
                        src="{{ !empty(auth()->user()->avatar) ? asset('storage/users/' . auth()->user()->avatar) : asset('assets/img/avatar_1nn.png') }}"
                        width="40" alt="avatar">
                    <span class="status online"></span>
                </span>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu user-dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-lg">
                        <img src="{{ !empty(auth()->user()->avatar) ? asset('storage/users/' . auth()->user()->avatar) : asset('assets/img/avatar_1nn.png') }}"
                            alt="User Image" class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <h6>{{ auth()->user()->name }}</h6>
                        <p class="text-muted mb-0">{{ auth()->user()->email ?? 'Administrator' }}</p>
                    </div>
                </div>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fe fe-user mr-1"></i> My Profile
                </a>
                @can('view-settings')
                    <a class="dropdown-item" href="{{ route('settings') }}">
                        <i class="fe fe-settings mr-1"></i> Settings
                    </a>
                @endcan
                <div class="dropdown-divider"></div>
                <a href="javascript:void(0)" class="dropdown-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fe fe-log-out mr-1"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        <!-- /User Menu -->
    </ul>
    <!-- /Header Right Menu -->
</div>
<!-- /Header -->

<style>
/* Enhanced Responsive Header */
.header {
    background: #fff;
    border-bottom: 2px solid #f0f0f0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    z-index: 1001;
    transition: all 0.3s ease;
    height: 60px;
}

/* Logo Area Improvements */
.header-left {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 0 20px;
    display: flex;
    align-items: center;
    height: 60px;
    min-width: 240px;
    position: relative;
    transition: all 0.3s ease;
}

.header-left::after {
    content: '';
    position: absolute;
    right: -20px;
    top: 0;
    bottom: 0;
    width: 20px;
    background: linear-gradient(135deg, #764ba2 0%, transparent 100%);
    clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    transition: all 0.3s ease;
}

.logo {
    display: flex;
    align-items: center;
    height: 100%;
    gap: 12px;
    text-decoration: none;
}

.logo-img {
    max-height: 40px;
    width: auto;
    filter: brightness(1) invert(0);
    transition: transform 0.3s ease;
    border-radius: 100%;
}

.logo-text {
    color: white;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 1px;
    text-decoration: none;
    transition: all 0.3s ease;
}

/* COLLAPSED STATE STYLES */
.main-wrapper.sidebar-collapsed .header-left {
    width: 70px !important;
    min-width: 70px !important;
    padding: 0 !important;
    justify-content: center !important;
}

.main-wrapper.sidebar-collapsed .header-left .logo-text {
    display: none !important;
}

.main-wrapper.sidebar-collapsed .header-left::after {
    display: none !important;
}

.main-wrapper.sidebar-collapsed .header-left .logo {
    justify-content: center;
    gap: 0;
}

.main-wrapper.sidebar-collapsed .header-left .logo-img {
    max-height: 35px;
}

/* Toggle Button */
#toggle_btn {
    font-size: 20px;
    color: #333;
    margin-left: 30px;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
}

#toggle_btn:hover {
    background: #f8f9fa;
    color: #667eea;
    transform: rotate(180deg);
    text-decoration: none;
}

.main-wrapper.sidebar-collapsed #toggle_btn {
    margin-left: 15px;
}

/* Header Action Buttons - Enhanced */
.header-action-btn {
    width: 44px;
    height: 44px;
    display: flex !important;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    transition: all 0.3s ease;
    position: relative;
    text-decoration: none;
    border: 1px solid rgba(102, 126, 234, 0.1);
    margin: 0 5px;
}

.header-action-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    text-decoration: none;
    border-color: transparent;
}

.header-action-btn i {
    font-size: 18px;
    transition: all 0.3s ease;
}

/* Special styling for POS button */
.quick-pos-btn {
    background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
    color: white;
    border-color: transparent;
}

.quick-pos-btn:hover {
    background: linear-gradient(135deg, #20a85a 0%, #3bc472 100%);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(40, 199, 111, 0.4);
}

/* Badge Improvements */
.badge-pill {
    position: absolute;
    top: -8px;
    right: -8px;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 8px;
    border-radius: 10px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse-badge 2s infinite;
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
    color: white;
    font-size: 11px;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-weight: 700;
    animation: pulse-notification 1.5s infinite;
    box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
}

@keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@keyframes pulse-notification {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.15); opacity: 0.8; }
}

/* User Menu Improvements */
.user-link {
    display: flex !important;
    align-items: center;
    gap: 12px;
    padding: 8px 16px !important;
    border-radius: 25px;
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    transition: all 0.3s ease;
    text-decoration: none;
    border: 1px solid rgba(102, 126, 234, 0.1);
    margin-left: 10px;
}

.user-link:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    text-decoration: none;
    border-color: transparent;
}

.user-link:hover .user-name {
    color: white;
}

.user-img {
    position: relative;
}

.status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    border: 2px solid #fff;
    border-radius: 50%;
    animation: pulse-status 2s infinite;
}

.status.online {
    background: #28c76f;
}

@keyframes pulse-status {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.user-name {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    transition: color 0.3s ease;
}

/* Dropdown Improvements */
.notifications {
    width: 380px;
    max-height: 500px;
    border: none;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    margin-top: 15px;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.user-dropdown-menu {
    width: 280px;
    border: none;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    margin-top: 15px;
    padding: 0;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .header-left {
        min-width: 60px;
        padding: 0 10px;
    }
    
    .logo-text {
        display: none;
    }
    
    .header-action-btn {
        width: 40px;
        height: 40px;
        margin: 0 2px;
    }
    
    .user-name {
        display: none;
    }
    
    .user-link {
        padding: 8px !important;
        gap: 0;
    }
    
    .notifications {
        width: 320px;
        margin-right: 10px;
    }
    
    .user-dropdown-menu {
        width: 240px;
        margin-right: 10px;
    }
    
    .badge-pill,
    .notification-badge {
        top: -5px;
        right: -5px;
        font-size: 9px;
        min-width: 16px;
        height: 16px;
    }
}

@media (max-width: 480px) {
    .header-action-btn {
        width: 36px;
        height: 36px;
    }
    
    .header-action-btn i {
        font-size: 16px;
    }
    
    .notifications {
        width: calc(100vw - 20px);
        margin: 10px;
        left: 0;
        right: 0;
        transform: translateX(0);
    }
    
    .user-dropdown-menu {
        width: calc(100vw - 20px);
        margin: 10px;
        left: 0;
        right: 0;
        transform: translateX(0);
    }
}

/* Mobile Menu Toggle */
.mobile_btn {
    display: none;
    color: #333;
    font-size: 20px;
    padding: 10px;
    margin-left: auto;
    margin-right: 15px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile_btn:hover {
    background: #f8f9fa;
    color: #667eea;
}

@media (max-width: 991.98px) {
    .mobile_btn {
        display: block;
    }
    
    #toggle_btn {
        display: none;
    }
}

/* Loading states */
.header-action-btn.loading {
    pointer-events: none;
    opacity: 0.7;
}

.header-action-btn.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>