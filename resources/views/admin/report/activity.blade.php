<x-app-layout>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="search-set">
                            <div class="search-path" >
                                <a class="btn btn-filter {{ $site_name || $tire_size || $brand_tire || $tire_pattern || $tahun  ? 'setclose' : ''}}" id="filter_search">
                                    <img src="assets/img/icons/filter.svg" alt="img">
                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                                </a>
                            </div>
                            <div class="search-path" {{ $site_name || $tire_size || $brand_tire || $tire_pattern || $tahun  ? 'style=display:block' : 'style=display:none'}}>
                                <a class="btn btn-filter bg-secondary" href="{{ Request::url() }}">
                                    <img src="assets/img/icons/filterclear.svg" alt="img">
                                </a>
                            </div>
                            <div class="search-path" >
                                <a class="btn btn-filter" onclick="document.getElementById('form-filter').submit()">
                                    <img src="assets/img/icons/search-whites.svg" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="mt-3" id="filter_inputs" {{ $site_name || $tire_size || $brand_tire || $tire_pattern || $tahun  ? 'style=display:block' : '' }}>
                            <form action="" id="form-filter">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Tire Site</label>
                                            <select class="form-control" name="site">
                                                <option value="">Choose Site</option>
                                                @foreach ($site as $item)
                                                    <option value="{{ $item->id }}" @selected($item->name == $site_name)>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Tire Size</label>
                                            <select class="form-control" name="tire_size">
                                                <option value="">Choose Size</option>
                                                @foreach ($tire_sizes as $item)
                                                    <option value="{{ $item->size }}" @selected($item->size == $tire_size)>
                                                        {{ $item->size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-2 col-sm-2 col-6">
                                        <label>Brand Tire</label>
                                        <select class="form-control" name="brand_tire">
                                            <option value="">Choose Brand Tire</option>
                                            @foreach ($manufacturer as $item)
                                                <option value="{{ $item->name }}" @selected($item->name == $brand_tire)>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-sm-2 col-6">
                                        <label>Tire Pattern</label>
                                        <select class="form-control" name="tire_pattern">
                                            <option value="">Choose Tire Pattern</option>
                                            @foreach ($tire_patterns as $item)
                                                <option value="{{ $item->pattern }}" @selected($item->pattern == $tire_pattern)>
                                                    {{ $item->pattern }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-sm-2 col-6">
                                        <label>Year</label>
                                        <select class="form-control" name="tahun">
                                            <option value="">Choose Year</option>
                                            @foreach ($date_range as $item)
                                                <option value="{{ $item }}" @selected($item == $tahun)>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-sm-2 col-6">
                                        <label>Month</label>
                                        <select class="form-control" name="month">
                                            <option value="">Choose Month</option>
                                            <option value="1" @selected($month == '1')>Jan</option>
                                            <option value="2" @selected($month == '2')>Feb</option>
                                            <option value="3" @selected($month == '3')>Mar</option>
                                            <option value="4" @selected($month == '4')>Apr</option>
                                            <option value="5" @selected($month == '5')>Mey</option>
                                            <option value="6" @selected($month == '6')>Jun</option>
                                            <option value="7" @selected($month == '7')>Jul</option>
                                            <option value="8" @selected($month == '8')>Aug</option>
                                            <option value="9" @selected($month == '9')>Sep</option>
                                            <option value="10" @selected($month == '10')>Okt</option>
                                            <option value="11" @selected($month == '11')>Nov</option>
                                            <option value="12" @selected($month == '12')>Des</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2 col-sm-2 col-6">
                                        <label>Week</label>
                                        <select class="form-control" name="week">
                                            <option value="">Choose Week</option>
                                            @for ($i = 1; $i < 56; $i++)
                                            <option value="{{ $i }}" @selected($week == $i)>Week {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                            <h4>{{ (int) $install_spare }}</h4>
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
                                            <h4>{{ (int) $install_repair }}</h4>
                                            <h5>REPAIR</h5>
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
                                    <h5>REPAIRING</h5>
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
                                    <h5>SCRAP</h5>
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
        {{-- Tire Fitment --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                            <h5>Sumary Fitments {{ $tahun }}
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
                            <h5>Weekly Fitments {{ \Carbon\Carbon::parse("2023-$month-01")->format("F") }}
                                <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                    <i data-feather="maximize"></i>
                                    <i class="d-none" data-feather="minimize"></i>
                                </a>

                                <select class="form-control" style="width: 20% !important;float: inline-end" name="axisX" onchange="this.parentElement.parentElement.submit()">
                                    <option value="week" @selected(Request::get("axisX") == "week")>week</option>
                                    <option value="day" @selected(Request::get("axisX") == "day")>day</option>
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
                        <h5>Dayly Fitments {{ $week }}
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

        {{-- Tire Removed --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Sumary Removed {{ $tahun }}
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
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <form action="">
                            <h5>Weekly Removed {{ \Carbon\Carbon::parse("2023-$month-01")->format("F") }}
                                <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                    <i data-feather="maximize"></i>
                                    <i class="d-none" data-feather="minimize"></i>
                                </a>
                                <select class="form-control" style="width: 20% !important;float: inline-end" name="axisX" onchange="this.parentElement.parentElement.submit()">
                                    <option value="week" @selected(Request::get("axisX") == "week")>week</option>
                                    <option value="day" @selected(Request::get("axisX") == "day")>day</option>
                                </select>
                            </h5>
                        </form>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-removed-month"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-removed-month'), Request::fullUrl()) }}">
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
                        <h5>Dayly Removed {{ $week }}
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
                                    <div id="chart-tire-removed-week"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-removed-week'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
