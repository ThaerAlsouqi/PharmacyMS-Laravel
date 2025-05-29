<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ucfirst(AppSettings::get('app_name', 'App')) }} - {{ ucfirst($title ?? '') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ !empty(AppSettings::get('favicon')) ? asset('storage/' . AppSettings::get('favicon')) : asset('assets/img/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/feathericon.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
    <!-- Snackbar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/snackbar/snackbar.min.css') }}">
    <!-- Sweet Alert css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Snackbar Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/snackbar/snackbar.min.css') }}">
    <!-- Select2 Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Page CSS -->
    @stack('page-css')
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- Add this to your app.blade.php in the <head> section after other CSS links -->
    @push('page-css')
        <style>
            /* Global Improvements */
            :root {
                --primary-color: #667eea;
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --success-color: #28c76f;
                --info-color: #00cfe8;
                --warning-color: #ff9f43;
                --danger-color: #ea5455;
                --dark-color: #4b4b4b;
                --light-bg: #f8f9fa;
                --border-color: #f0f0f0;
                --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
                --shadow-md: 0 5px 20px rgba(0, 0, 0, 0.08);
                --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            * {
                transition: all 0.3s ease;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: #f5f6fa;
                color: var(--dark-color);
            }

            /* Page Wrapper */
            .page-wrapper {
                margin-left: 240px;
                padding-top: 60px;
                min-height: 100vh;
                background-color: #f5f6fa;
            }

            /* Content Container */
            .content {
                padding: 30px;
            }

            /* Page Header Improvements */
            .page-header {
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid var(--border-color);
            }

            /* Card Improvements */
            .card {
                border: none;
                border-radius: 15px;
                box-shadow: var(--shadow-md);
                margin-bottom: 30px;
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: var(--shadow-lg);
                transform: translateY(-2px);
            }

            .card-header {
                background: transparent;
                border-bottom: 1px solid var(--border-color);
                padding: 20px;
                font-weight: 600;
            }

            .card-body {
                padding: 25px;
            }

            /* Button Improvements */
            .btn {
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
                border: none;
            }

            .btn-primary {
                background: var(--primary-gradient);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            }

            .btn-success {
                background: var(--success-color);
                color: white;
            }

            .btn-success:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(40, 199, 111, 0.3);
            }

            .btn-danger {
                background: var(--danger-color);
                color: white;
            }

            .btn-danger:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(234, 84, 85, 0.3);
            }

            /* Form Improvements */
            .form-control {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 12px 15px;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
            }

            .form-group label {
                font-weight: 500;
                color: var(--dark-color);
                margin-bottom: 8px;
            }

            /* Table Improvements */
            .table {
                border-radius: 10px;
                overflow: hidden;
            }

            .table thead th {
                background: var(--light-bg);
                border: none;
                padding: 15px;
                font-weight: 600;
                color: var(--dark-color);
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 0.5px;
            }

            .table tbody td {
                padding: 15px;
                vertical-align: middle;
                border-top: 1px solid var(--border-color);
            }

            .table tbody tr:hover {
                background: var(--light-bg);
            }

            /* Badge Improvements */
            .badge {
                padding: 6px 12px;
                border-radius: 20px;
                font-weight: 500;
                font-size: 12px;
            }

            .badge-success {
                background: rgba(40, 199, 111, 0.1);
                color: var(--success-color);
            }

            .badge-danger {
                background: rgba(234, 84, 85, 0.1);
                color: var(--danger-color);
            }

            .badge-warning {
                background: rgba(255, 159, 67, 0.1);
                color: var(--warning-color);
            }

            .badge-info {
                background: rgba(0, 207, 232, 0.1);
                color: var(--info-color);
            }

            /* Modal Improvements */
            .modal-content {
                border: none;
                border-radius: 15px;
                box-shadow: var(--shadow-lg);
            }

            .modal-header {
                background: var(--primary-gradient);
                color: white;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }

            .modal-header .close {
                color: white;
                opacity: 0.8;
            }

            .modal-header .close:hover {
                opacity: 1;
            }

            /* Alert Improvements */
            .alert {
                border: none;
                border-radius: 10px;
                padding: 15px 20px;
                margin-bottom: 20px;
            }

            .alert-danger {
                background: rgba(234, 84, 85, 0.1);
                color: var(--danger-color);
            }

            .alert-success {
                background: rgba(40, 199, 111, 0.1);
                color: var(--success-color);
            }

            /* Select2 Improvements */
            .select2-container--default .select2-selection--single {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                height: 45px;
                padding: 6px 12px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 32px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 43px;
            }

            .select2-dropdown {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                box-shadow: var(--shadow-md);
            }

            /* Breadcrumb Improvements */
            .breadcrumb {
                background: transparent;
                padding: 0;
                margin-bottom: 0;
            }

            .breadcrumb-item {
                font-size: 14px;
            }

            .breadcrumb-item.active {
                color: var(--primary-color);
            }

            /* Loading State */
            .loading {
                position: relative;
                pointer-events: none;
                opacity: 0.6;
            }

            .loading::after {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 40px;
                height: 40px;
                border: 3px solid var(--primary-color);
                border-radius: 50%;
                border-top-color: transparent;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: translate(-50%, -50%) rotate(0deg);
                }

                100% {
                    transform: translate(-50%, -50%) rotate(360deg);
                }
            }

            /* Responsive Improvements */
            @media (max-width: 991.98px) {
                .page-wrapper {
                    margin-left: 0;
                }

                .content {
                    padding: 20px 15px;
                }
            }

            /* Scrollbar Styling */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: var(--primary-color);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #5a67d8;
            }

            /* Animation Classes */
            .fade-in {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Hover Effects */
            .hover-scale {
                transition: transform 0.3s ease;
            }

            .hover-scale:hover {
                transform: scale(1.05);
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
            }

            .empty-state i {
                font-size: 64px;
                color: #dee2e6;
                margin-bottom: 20px;
            }

            .empty-state h5 {
                color: #6c757d;
                margin-bottom: 10px;
            }

            .empty-state p {
                color: #adb5bd;
            }
        </style>
    @endpush
</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('admin.includes.header')
        <!-- /Header -->

        <!-- Sidebar -->
        @include('admin.includes.sidebar')
        <!-- /Sidebar -->
        <!-- Add this style block in your app.blade.php after the sidebar include -->
        <style>
            /* Force override submenu styles */
            .sidebar .submenu ul {
                background-color: transparent !important;
                background: transparent !important;
            }

            .sidebar .submenu ul li {
                background-color: transparent !important;
                background: transparent !important;
                list-style: none !important;
            }

            .sidebar .submenu ul li a {
                background-color: transparent !important;
                background: transparent !important;
                color: #6c757d !important;
                display: block !important;
                padding: 10px 20px 10px 45px !important;
                text-decoration: none !important;
                transition: all 0.3s ease !important;
            }

            .sidebar .submenu ul li a:hover {
                background-color: rgba(102, 126, 234, 0.05) !important;
                background: rgba(102, 126, 234, 0.05) !important;
                color: #667eea !important;
                padding-left: 50px !important;
            }

            .sidebar .submenu ul li a.active {
                color: #667eea !important;
                font-weight: 600 !important;
                background-color: transparent !important;
                background: transparent !important;
            }

            /* Remove any dark theme or default black backgrounds */
            .sidebar-menu .submenu ul {
                background: #f8f9fa !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* Ensure text is visible */
            .sidebar-menu .submenu ul li a {
                color: #6c757d !important;
            }

            .sidebar-menu .submenu ul li a:hover,
            .sidebar-menu .submenu ul li a.active {
                color: #667eea !important;
            }
        </style>
        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        @stack('page-header')
                    </div>
                </div>
                <!-- /Page Header -->
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <x-alerts.danger :error="$error" />
                    @endforeach
                @endif

                @yield('content')
                <!-- add sales modal-->
                <x-modals.add-sale />
                <!-- / add sales modal -->
            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->



</body>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- Sweet Alert Js -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Snackbar Js -->
<script src="{{ asset('assets/plugins/snackbar/snackbar.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    $(document).ready(function() {
        $('body').on('click', '#deletebtn', function() {
            var id = $(this).data('id');
            var route = $(this).data('route');
            swal.queue([{
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: '<i class="fe fe-trash mr-1"></i> Delete!',
                cancelButtonText: '<i class="fa fa-times mr-1"></i> Cancel!',
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1,
                preConfirm: function() {
                    return new Promise(function() {
                        $.ajax({
                            url: route,
                            type: "DELETE",
                            data: {
                                "id": id
                            },
                            success: function() {
                                swal.insertQueueStep(
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Resource has been deleted.",
                                        type: "success",
                                        showConfirmButton: !
                                            1,
                                        timer: 1500,
                                    })
                                )
                                $('.datatable').DataTable().ajax
                                    .reload();
                            }
                        })

                    })
                }
            }]).catch(swal.noop);
        });
    });
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    actionTextColor: '#fff',
                    backgroundColor: '#2196f3'
                });
                break;

            case 'warning':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e2a03f'
                });
                break;

            case 'success':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#8dbf42'
                });
                break;

            case 'danger':
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                });
                break;
        }
    @endif
</script>

<!-- Page JS -->
@stack('page-js')

 <script>
// Enhanced Sidebar Collapse with Error Handling
document.addEventListener('DOMContentLoaded', function() {
    try {
        const toggleBtn = document.getElementById('toggle_btn');
        const sidebar = document.getElementById('sidebar');
        const mainWrapper = document.querySelector('.main-wrapper');
        
        if (!toggleBtn || !sidebar || !mainWrapper) {
            console.log('Sidebar elements not found');
            return;
        }
        
        console.log('✅ Found all sidebar elements');
        
        // Add tooltips data to sidebar items
        sidebar.querySelectorAll('.sidebar-menu > ul > li').forEach(item => {
            const span = item.querySelector('a span');
            if (span && !item.classList.contains('menu-title')) {
                item.setAttribute('data-tooltip', span.textContent.trim());
            }
        });
        
        // Load saved state
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            sidebar.classList.add('collapsed');
            mainWrapper.classList.add('sidebar-collapsed');
        }
        
        // Toggle functionality
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent event bubbling
            
            try {
                const isCollapsed = sidebar.classList.contains('collapsed');
                
                console.log('Toggle clicked, currently collapsed:', isCollapsed);
                
                if (isCollapsed) {
                    // Expand
                    sidebar.classList.remove('collapsed');
                    mainWrapper.classList.remove('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', 'false');
                    console.log('✅ Sidebar expanded');
                } else {
                    // Collapse
                    sidebar.classList.add('collapsed');
                    mainWrapper.classList.add('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', 'true');
                    console.log('✅ Sidebar collapsed');
                }
                
                // Trigger resize event for any components that need it
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 300);
                
            } catch (toggleError) {
                console.error('Error in toggle function:', toggleError);
            }
        });
        
        // Mobile responsive
        const mobileBtn = document.getElementById('mobile_btn');
        if (mobileBtn) {
            mobileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('mobile-open');
            });
        }
        
        console.log('✅ Sidebar collapse functionality loaded successfully');
        
    } catch (error) {
        console.error('❌ Error initializing sidebar:', error);
    }
});
</script>
</html>
