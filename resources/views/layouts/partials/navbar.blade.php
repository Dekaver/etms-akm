<div class="header">

    <!-- Logo -->
    <div class="header-left active">
        <a href="/dashboard" class="logo logo-normal">
            <img src="{{ asset('assets/img/logo.png') }}" alt="">
        </a>
        <a href="/dashboard" class="logo logo-white">
            <img src="{{ asset('assets/img/logo-white.png') }}" alt="">
        </a>
        <a href="/dashboard" class="logo-small">
            <img src="{{ asset('assets/img/logo-small.png') }}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
        </a>
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu justify-content-end" style="position: relative; float: none;">

        <li class="nav-item h-100 d-flex align-items-center " style="position: absolute; left: 1.5rem;">
            <div class="btn-group btn-group-md">
                <a href="/tirerunning" type="button" class="btn btn-primary">
                    <i class="fa-solid fa-up-down-left-right me-2"></i>Tire Movement
                </a>
                <a href="/dailyinspect" type="button" class="btn btn-success">
                    <i class="fa-solid fa-clipboard me-2"></i>Daily Monitoring
                </a>
            </div>
        </li>
        {{-- <li class="nav-item">
            <div class="top-nav-search">

                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="#">
                    <div class="searchinputs">
                        <input type="text" placeholder="Search Here ...">
                        <div class="search-addon">
                            <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                        </div>
                    </div>
                    <a class="btn" id="searchdiv"><img src="{{ asset('assets/img/icons/search.svg') }}"
                            alt="img"></a>
                </form>
            </div>
        </li> --}}
        <!-- /Search -->

        <!-- Flag -->
        {{-- <li class="nav-item dropdown has-arrow flag-nav">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                <img src="{{ asset('assets/img/flags/us1.png') }}" alt="" height="20">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="javascript:void(0);" class="dropdown-item">
                    <img src="{{ asset('assets/img/flags/us.png') }}" alt="" height="16"> English
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                    <img src="{{ asset('assets/img/flags/fr.png') }}" alt="" height="16"> French
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                    <img src="{{ asset('assets/img/flags/es.png') }}" alt="" height="16"> Spanish
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                    <img src="{{ asset('assets/img/flags/de.png') }}" alt="" height="16"> German
                </a>
            </div>
        </li> --}}
        <!-- /Flag -->

        <li class="nav-item d-flex align-items-center justify-content-center">
            <p class="fw-bold">{{ strtoupper(auth()->user()->company->name ?? '') }}</p>
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-img"><img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="">
                    <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ asset('assets/img/profiles/avator1.jpg') }}" alt="">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                            <h6>John Doe</h6>
                            <h5>Admin</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="/profile"> <i class="me-2" data-feather="user"></i>
                        My Profile</a>
                    {{-- <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                            data-feather="settings"></i>Settings</a> --}}
                    <hr class="m-0">
                    <form action="{{ route('logout') }}" id="logout-form" method="post">
                        @csrf
                        <a class="dropdown-item logout pb-0" onclick="document.getElementById('logout-form').submit()">
                            <img src="{{ asset('assets/img/icons/log-out') }}.svg" class="me-2" alt="img">Logout
                        </a>
                    </form>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/img/icons/transfer1') }}.svg" alt="img" width="20px">
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Switch Company</span>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @foreach ($companies as $item)
                            <li class="notification-message">
                                <form action="{{ route('user.company.update', $item->id) }}" method="post">
                                    @csrf
                                    <a onclick="document.parentElement.submit()">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                                <img alt=""
                                                    src="https://arshakamandiri.com/wp-content/uploads/2023/01/thhumbnail-arrshaka.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                                <p class="noti-details mb-0"><span
                                                        class="noti-title">{{ $item->name }}</span>
                                                </p>
                                                <p class="noti-time"><span
                                                        class="notification-time">{{ $item->city . ', ' }}
                                                        {{ $item->state }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            </li>
                        @endforeach
                        {{-- <li class="notification-message">
                            <a href="/dashboard">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="https://electrek.co/wp-content/uploads/sites/3/2021/12/Goodyear-EV-Tire.jpg?quality=82&strip=all">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details mb-0"><span class="noti-title">PT. SINAR MAS JAYA</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">Pontianak, Kalimantan Barat</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="/dashboard">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="https://www.datocms-assets.com/27230/1610258420-michelin.png">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details mb-0"><span class="noti-title">PT. MICHELIN INDONESIA</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">Bandung, Jawa Barat</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="activities.html">View all Company</a>
                </div>
            </div>
        </li>
        {{-- <div class="dropdown">
            <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                2022 <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a href="javascript:void(0);" class="dropdown-item">2022</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item">2021</a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item">2020</a>
                </li>
            </ul>
        </div> --}}


    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="/profile">My Profile</a>
            {{-- <a class="dropdown-item" href="myCompany">Settings</a> --}}
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="dropdown-item" type="submit">Logout</button>
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
