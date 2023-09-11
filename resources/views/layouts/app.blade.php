<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>I-Mirs</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo Taci White.png') }}" type="image/png">

    <!-- STYLES -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')

</head>

<body id="app">

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div id="main" class="layout-horizontal">
        <header class="mb-2">
            <div class="header-top">
                <div class="container">
                    <div class="card my-0">
                        <a href="{{ route('home') }}"><img width="120" height="30"
                                src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"></a>
                    </div>
                    <div class="header-top-right">
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <i class="fa-solid fa-sun"></i>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <i class="fa-solid fa-moon"></i>
                        </div>

                        <a class="position-relative mr-2" href="#" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                            <i class="fa-solid fa-bell fs-4"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notifcount }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>

                        <div class="dropdown">
                            <a href="#" id="topbarUserDropdown"
                                class="user-dropdown d-flex align-items-center dropend dropdown-toggle "
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar avatar-md2">
                                    <img src="{{ asset('assets/images/faces/1.jpg') }}" alt="Avatar">
                                </div>
                                <div class="text">
                                    <h6 class="user-dropdown-name">{{ $loginUser->name }}</h6>
                                    <p class="user-dropdown-status text-sm text-muted">
                                        {{ $loginUser->jabatan }}</p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>

                                </li>
                            </ul>
                        </div>
                        <!-- Burger button responsive -->
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                    </div>
                </div>
            </div>
            <nav class="main-navbar">
                <div class="container">
                    <ul>
                        <li class="menu-item  ">
                            <a href="{{ route('home') }}" class='menu-link'>
                                <span><i class="fas fa-grip"></i> Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-item  ">
                            <a href="{{ route('request') }}" class='menu-link'>
                                <span><i class="fas fa-ticket"></i> Create Repair Ticket</span>
                            </a>
                        </li>
                        <li class="menu-item  ">
                            <a href="{{ route('partrepair.waitingapprove.index') }}" class='menu-link'>
                                <span>
                                    <i class="fas fa-file-signature"></i> Waiting Approval
                                </span>
                                @if ($waiting_approve > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $waiting_approve }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="menu-item  has-sub">
                            <a href="#" class='menu-link'>
                                <span><i class="fas fa-list"></i> Ticket Repair Table</span>
                                @if ($allprogress > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $allprogress }}</span>
                                @endif
                            </a>
                            <div class="submenu ">
                                <div class="submenu-group-wrapper">
                                    <ul class="submenu-group">
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('partrepair.waitingtable.index') }}"
                                                class='submenu-link'>Waiting
                                                Table
                                                <span class="badge bg-danger rounded-pill">{{ $allprogress }}</span>
                                            </a>

                                        </li>
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('partrepair.progress-subcont-table') }}" class='submenu-link'>Progress Subcont</a>
                                        </li>
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('finishtable') }}" class='submenu-link'>Finish
                                                Table</a>
                                        </li>
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('partrepair.stockout.index') }}"
                                                class='submenu-link'>Stockout
                                                Table</a>
                                        </li>
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('deletedtable') }}" class='submenu-link'>Deleted
                                                Table</a>
                                        </li>
                                        <li class="submenu-item  ">
                                            <a class="list-group-item list-group-item-action list-group-item-light"
                                                href="{{ route('partrepair.registeredticket.index') }}"
                                                class='submenu-link'>Total Registered</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="menu-item  ">
                            <a href="{{ route('ganttchart') }}" class='menu-link'>
                                <span><i class="fas fa-calendar-alt"></i> Schedule Chart</span>
                            </a>
                        </li>

                        @if ($loginUser->jabatan == 'ADMIN')
                            <li class="menu-item  has-sub">
                                <a href="#" class='menu-link'>
                                    <span><i class="fas fa-database"></i> Master Data</span>
                                </a>
                                <div class="submenu ">
                                    <div class="submenu-group-wrapper">
                                        <ul class="submenu-group">

                                            @can('AdminSupervisor')
                                                <li class="submenu-item  ">
                                                    <a class="list-group-item list-group-item-action list-group-item-light"
                                                        href="{{ route('user.index') }}" class='submenu-link'>User</a>
                                                </li>
                                            @endcan

                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('section.index') }}"
                                                    class='submenu-link'>Section</a>
                                            </li>
                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('line.index') }}" class='submenu-link'>Line</a>
                                            </li>
                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('machine.index') }}"
                                                    class='submenu-link'>Machine</a>
                                            </li>

                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('repair_kit.index') }}"
                                                    class='submenu-link'>Repair
                                                    Kit</a>
                                            </li>
                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('item_standard.index') }}"
                                                    class='submenu-link'>Item
                                                    Standard</a>
                                            </li>
                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('category_code.index') }}"
                                                    class='submenu-link'>Category
                                                    Code</a>
                                            </li>
                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('maker.index') }}" class='submenu-link'>Maker</a>
                                            </li>

                                            <li class="submenu-item  ">
                                                <a class="list-group-item list-group-item-action list-group-item-light"
                                                    href="{{ route('subcont.index') }}"
                                                    class='submenu-link'>Subcont</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endif
                        {{-- @endif --}}

                        <li class="menu-item  ">
                            <a href="{{ route('report') }}" class='menu-link'>
                                <span><i class="fas fa-sheet-plastic"></i> Report</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-black" id="offcanvasExampleLabel">Delay Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body text-black">
                    <ol class="list-group list-group-numbered">

                        @forelse ($notif as $not)
                            <a href="{{ route('partrepair.waitingtable.show', $not->id) }}"
                                class="list-group-item list-group-item-action list-group-item-danger d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $not->item_name }}</div>
                                    Plan Finish {{ Carbon\Carbon::parse($not->plan_finish_repair)->format('d M y') }}
                                </div>
                                <span class="badge bg-danger rounded-pill">{{ $not->progress }}</span>
                            </a>
                        @empty
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Aman</div>
                                    Tidak ada delay
                                </div>
                            </li>
                        @endforelse
                    </ol>
                </div>
            </div>
        </header>

        <div id="app">
            @yield('content')
        </div>

</body>


<!-- SCRIPT -->
<script src="{{ asset('js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        $('input.number').number(true)
        $('input.number2').number(true, 2)

        $('span.number').number(true)
        $('span.number2').number(true, 2)
    });
</script>
@if ($message = Session::get('no_waiting_part'))
    <script>
        Toastify({
            text: "{{ $message }}",
            duration: 2500,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#4fbe87",
        }).showToast()
    </script>
@endif

@yield('script')

</html>
