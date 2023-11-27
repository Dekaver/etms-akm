<x-app-layout>
    @php
        $now = \Carbon\Carbon::now();
    @endphp
    @push('css')
        <style>
            .graphic-container {
                min-height: 380px;
                max-height: 380px;
                overflow-y: auto;
                overflow-x: hidden;
            }

            .dash-count a {
                color: white;
            }
        </style>
        <div class="page-header">
            <div class="page-title">
                <h4>{{ strtoupper(auth()->user()->company->name ?? '') }} - {{ auth()->user()->site->name ?? '' }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ auth()->user()->name }}</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="card" style="background: #0d4781!important;">
                    <div class="card-body">
                        <div class="row rounded-3 w-100">
                            <div class="col dash-count px-2 justify-content-start align-items-center">
                                <div class="dash-imgs me-2">
                                    <img src="assets/img/dashboard/icon3.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $stok_new + (int) $stok_spare + (int) $stok_repair }}</h4>
                                    <h5>TIRE INVENTORY</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon1.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_new }}</h4>
                                            <h5>NEW</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon3.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_spare }}</h4>
                                            <h5>SPARE</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon4.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_repair }}</h4>
                                            <h5>REPAIR</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-12">
                <div class="card" style="background: #198148!important;">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2">
                                    <img src="assets/img/dashboard/icon5.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $install_new + (int) $install_spare + (int) $install_repair }}</h4>
                                    <h5>TIRE INSTALL</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon1.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_new }}</h4>
                                            <a href="/report-tire-running?tire_status=NEW">
                                                <h5>NEW</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon3.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_spare }}</h4>
                                            <a href="/report-tire-running?tire_status=SPARE">
                                                <h5>SPARE</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon4.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_repair }}</h4>
                                            <a href="/report-tire-running?tire_status=REPAIR">
                                                <h5>REPAIR</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="card" style="background: #e07218!important;margin-bottom: 11px">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon2.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $repairing }}</h4>
                                    <a href="/tirerepair">
                                        <h5>REPAIRING</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="background: #ad2525!important;">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon6.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $scrap }}</h4>
                                    <a href="/tiremaster?tirestatus=5">
                                        <h5>SCRAP</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="card" style="background: #6AB187!important;margin-bottom: 11px">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon2.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $schedule }}</h4>
                                    <h5>SCHEDULE</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="background: #488A99!important;">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon6.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $unschedule }}</h4>
                                    <h5>UNSCHEDULE</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Tire Stok</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>1 Minggu</th>
                                    <th>1 Bulan</th>
                                    <th>2 Bulan</th>
                                    <th>>2 Bulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $stok_days["day1"] }}</td>
                                    <td>{{ $stok_days["day2"] }}</td>
                                    <td>{{ $stok_days["day3"] }}</td>
                                    <td>{{ $stok_days["day4"] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Tire Install</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>1 Minggu</th>
                                    <th>1 Bulan</th>
                                    <th>2 Bulan</th>
                                    <th>>2 Bulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $running_days["day1"] }}</td>
                                    <td>{{ $running_days["day2"] }}</td>
                                    <td>{{ $running_days["day3"] }}</td>
                                    <td>{{ $running_days["day4"] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="d-none row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Tire Inventory
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                                <i class="d-none" data-feather="minimize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-inventory"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-inventory'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Sumary Fitments of {{ $now->format('Y') }}
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                                <i class="d-none" data-feather="minimize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-fitment"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-fitment'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <form action="">
                            <h5>Weekly Fitments of {{ $now->format('F') }}
                                <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                    <i data-feather="maximize"></i>
                                    <i class="d-none" data-feather="minimize"></i>
                                </a>
                                <select class="form-control" style="width: 20% !important;float: inline-end"
                                    name="axisX" onchange="this.parentElement.parentElement.submit()">
                                    <option value="week" @selected(Request::get('axisX') == 'week')>week</option>
                                    <option value="day" @selected(Request::get('axisX') == 'day')>day</option>
                                </select>
                            </h5>
                        </form>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-fitment-month"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-fitment-month'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Dayly Fitments of Week {{ $now->weekOfYear }}
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                                <i class="d-none" data-feather="minimize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-fitment-week"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-fitment-week'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Tire Removed
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                                <i class="d-none" data-feather="minimize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-removed"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-removed'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        @push('js')
            <script src="{{ asset('assets/view/grafik.js') }}"></script>

            <script>
                function toggleFullScreen(e) {

                    elem = e.parentElement.parentElement.parentElement;
                    icon_max = e.children[0]
                    icon_min = e.children[1]
                    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document
                            .msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document
                            .mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !==
                            undefined && !document.webkitIsFullScreen)) {
                        if (elem.requestFullScreen) {
                            elem.requestFullScreen();
                        } else if (elem.mozRequestFullScreen) {
                            elem.mozRequestFullScreen();
                        } else if (elem.webkitRequestFullScreen) {
                            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                        } else if (elem.msRequestFullscreen) {
                            elem.msRequestFullscreen();
                        }
                    } else {
                        if (document.cancelFullScreen) {
                            document.cancelFullScreen();
                        } else if (document.mozCancelFullScreen) {
                            document.mozCancelFullScreen();
                        } else if (document.webkitCancelFullScreen) {
                            document.webkitCancelFullScreen();
                        } else if (document.msExitFullscreen) {
                            document.msExitFullscreen();
                        }
                    }
                }
                // Get the fullscreen element
                var fullscreenElement = document.fullscreenElement || document.webkitFullscreenElement || document
                    .mozFullScreenElement || document.msFullscreenElement;

                // Function to handle fullscreen change
                function fullscreenChangeHandler() {
                    if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document
                        .msFullscreenElement) {

                        icon_max.classList.add('d-none');
                        icon_min.classList.remove('d-none');
                    } else {
                        icon_max.classList.remove('d-none');
                        icon_min.classList.add('d-none');
                    }
                }

                // Add event listener for fullscreen change
                document.addEventListener('fullscreenchange', fullscreenChangeHandler);
                document.addEventListener('webkitfullscreenchange', fullscreenChangeHandler);
                document.addEventListener('mozfullscreenchange', fullscreenChangeHandler);
                document.addEventListener('MSFullscreenChange', fullscreenChangeHandler);
            </script>
        @endpush

    </x-app-layout>
