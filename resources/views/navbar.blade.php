@php

$notificationService = app(\App\Services\notifications::class);

$unread = $notificationService->unreadCount();

$notifications = $notificationService->latestNotifications();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #f5f7fb;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        .top-navbar {
            height: 65px;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
        }

        .menu-btn {
            font-size: 26px;
            color: white;
            cursor: pointer;
            margin-right: 15px;
        }

        .brand-logo {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar {
            width: 270px;
            height: calc(100vh - 65px);
            background: #111827;
            position: fixed;
            top: 65px;
            left: -270px;
            transition: 0.3s;
            overflow-y: auto;
            z-index: 1040;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #d1d5db;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            transition: 0.2s;
            border-radius: 8px;
            margin: 4px 10px;
        }

        .sidebar .nav-link:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar .nav-link i {
            font-size: 18px;
        }

        .main-content {
            margin-top: 80px;
            margin-left: 0;
            padding: 20px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .badge-chat {
            margin-left: auto;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .dropdown-menu {
            z-index: 9999 !important;
        }

        @media(max-width: 768px) {

            .main-content {
                margin-left: 0 !important;
            }

        }
    </style>
</head>

<body>


    <div class="top-navbar">

        <div class="d-flex align-items-center">
            <i class="bi bi-list menu-btn" id="menuToggle"></i>

            <h4 class="brand-logo ms-2">SupportDesk</h4>
        </div>

        <div class="ms-auto d-flex align-items-center gap-3">

            @if(auth()->check())


            <div class="bg-white text-dark rounded-pill px-3 py-2 d-flex align-items-center gap-2 shadow-sm">

                <i class="bi bi-person-circle fs-5 text-primary"></i>

                <span class="fw-semibold">
                    {{ auth()->user()->name ?? auth()->user()->email }}
                </span>

            </div>


            <form method="POST"
                action="{{ route('logout') }}"
                id="logoutForm"
                class="m-0">

                @csrf

                <button type="submit"
                    class="btn btn-danger rounded-pill px-3 py-2 d-flex align-items-center gap-2 shadow-sm border-0">

                    <i class="bi bi-box-arrow-right"></i>

                    <span class="fw-semibold">
                        Logout
                    </span>

                </button>

            </form>

            <div class="dropdown">

                <button class="btn p-0 position-relative text-white dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                    <i class="bi bi-bell fs-4"></i>

                    @if($unread > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unread }}
                    </span>
                    @endif

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow"
                    style="width:300px; max-height:400px; overflow:auto; z-index:2000;">

                    <li class="dropdown-header fw-bold">
                        Notifications
                    </li>

                    @forelse($notifications as $note)

                    <li class="border-bottom py-2 px-2">
                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <small class="fw-bold">{{ $note->title }}</small><br>
                                <small class="text-muted">{{ $note->description }}</small>
                            </div>

                            <a href="{{ route('notification.open', $note->id) }}">
                                <i class="bi bi-plus-circle text-success fs-5"></i>
                            </a>

                        </div>
                    </li>

                    @empty
                    <li class="text-center text-muted py-2">
                        No Notifications
                    </li>
                    @endforelse

                </ul>

            </div>


        </div>

        @endif

    </div>


    <div class="sidebar" id="sidebar">

        <ul class="nav flex-column">

            {{-- ========================================= --}}
            {{-- SUPER ADMIN --}}
            {{-- ========================================= --}}
            @role('Super Admin')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('role.data') }}">
                    <i class="bi bi-people"></i>
                    Manage Users
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('role.show') }}">
                    <i class="bi bi-plus-square"></i>
                    Create Role
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('role.index') }}">
                    <i class="bi bi-shield-lock"></i>
                    Roles & Permissions
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('team.create') }}">
                    <i class="bi bi-diagram-3"></i>
                    Create Team
                </a>
            </li>
               <li class="nav-item">
                <a class="nav-link" href="{{ route('team.showindex') }}">
                   <i class="bi bi-person-lines-fill"></i>
                    Manage Teams
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.showindex') }}">
                    <i class="bi bi-ticket-detailed"></i>
                    All Tickets
                </a>
            </li>
           
             <li class="nav-item">
                <a class="nav-link" href="{{ route('role.data') }}">
                    <i class="bi bi-person"></i>
                    User 
                </a>
            </li>

            <li class="nav-item">
    <a class="nav-link" href="{{ route('report.tickets') }}">
        <i class="bi bi-ticket-detailed"></i>
        Tickets Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.agent') }}">
        <i class="bi bi-people-fill"></i>
        Agents Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.agentsla') }}">
        <i class="bi bi-exclamation-triangle-fill"></i>
        SLA Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.customer') }}">
        <i class="bi bi-person-lines-fill"></i>
        Customer Report
    </a>
</li>





            @endrole



            {{-- ========================================= --}}
            {{-- ADMIN --}}
            {{-- ========================================= --}}
            @role('Admin')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('team.showindex') }}">
                   <i class="bi bi-person-lines-fill"></i>
                    Manage Teams
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('team.create') }}">
                    <i class="bi bi-diagram-3"></i>
                  Create Teams
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('team.showform') }}">
                    <i class="bi bi-person-check"></i>
                    Assign Tickets
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('role.data') }}">
                    <i class="bi bi-person"></i>
                    User 
                </a>
            </li>
            <li class="nav-item">
    <a class="nav-link" href="{{ route('report.tickets') }}">
        <i class="bi bi-ticket-detailed"></i>
        Tickets Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.agent') }}">
        <i class="bi bi-people-fill"></i>
        Agents Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.agentsla') }}">
        <i class="bi bi-exclamation-triangle-fill"></i>
        SLA Report
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('report.customer') }}">
        <i class="bi bi-person-lines-fill"></i>
        Customer Report
    </a>
</li>



            @endrole



            {{-- ========================================= --}}
            {{-- TEAM LEADER --}}
            {{-- ========================================= --}}
            @role('Team Leader')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('leader.tickets') }}">
                    <i class="bi bi-ticket-detailed"></i>
                    Team Tickets
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('leader.myteam') }}">
                    <i class="bi bi-people-fill"></i>
                    Team Members
                </a>
            </li>



            @endrole



            {{-- ========================================= --}}
            {{-- SUPPORT AGENT --}}
            {{-- ========================================= --}}
            @role('Support Agent')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('agent.showpage') }}">
                    <i class="bi bi-ticket"></i>
                    Assigned Tickets
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('Comments.list') }}">
                    <i class="bi bi-chat-left-text"></i>
                    Comments
                </a>
            </li>

            @endrole



            {{-- ========================================= --}}
            {{-- CUSTOMER --}}
            {{-- ========================================= --}}
            @role('Customer')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    Create Ticket
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('customer.datalist') }}">
                    <i class="bi bi-ticket-detailed"></i>
                    My Tickets
                </a>
            </li>

            @endrole



            {{-- ========================================= --}}
            {{-- COMMON FOR ALL LOGGED USERS --}}
            {{-- ========================================= --}}
            @auth

            <li class="nav-item">
                <a class="nav-link" href="{{ route('chat.test') }}">
                    <i class="bi bi-chat-dots"></i>
                    Chat
                </a>
            </li>

            @endauth

        </ul>

    </div>

    @can('reassign-team-tickets')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('leader.tickets') }}">
            Team Leader Tickets
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('leader.myteam') }}">
            Team Member
        </a>
    </li>
    @endcan


    </ul>
    </div>



    <div class="main-content"
        id="mainContent">

        @yield('content')

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const menuToggle = document.getElementById('menuToggle');

        const sidebar = document.getElementById('sidebar');

        const mainContent = document.getElementById('mainContent');





        if (localStorage.getItem('sidebarOpen') === 'true') {

            sidebar.style.left = '0';

            mainContent.style.marginLeft = '270px';

        } else {

            sidebar.style.left = '-270px';

            mainContent.style.marginLeft = '0';

        }




        menuToggle.addEventListener('click', function() {

            if (sidebar.style.left === '0px') {

                sidebar.style.left = '-270px';

                mainContent.style.marginLeft = '0';

                localStorage.setItem('sidebarOpen', 'false');

            } else {

                sidebar.style.left = '0';

                mainContent.style.marginLeft = '270px';

                localStorage.setItem('sidebarOpen', 'true');

            }

        });
    </script>

</body>

</html>