<x-app-layout>
    <div class="row">
        <div class="col-xl-12">
            <form action="" method="get">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Filter</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Site</label>

                                {{-- @canany(['isSuperAdmin', 'isViewer', 'isManager']) --}}
                                <select class="form-control" name="site">
                                    <option value="">Choose Site</option>
                                    @foreach ($site as $item)
                                        <option value="{{ $item->name }}" @selected($item->name == $site_name)>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                {{-- @else
                                    <input class="form-control" type="text" name="site" value="{{ $site_name }}" readonly>
                                @endcanany --}}
                            </div>
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Year</label>
                                {{-- <input class="form-control" type="text" name="tahun" max="9999" min="2000"
                                    maxlength="4" value="{{ $tahun }}"> --}}
                                <select class="form-control" name="tahun">
                                    <option value="">Choose Year</option>
                                    @foreach ($date_range as $item)
                                        <option value="{{ $item }}" @selected($item == $tahun)>
                                            {{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-sm-3 col-6">
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
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Week</label>
                                <select class="form-control" name="week">
                                    <option value="">Choose Week</option>
                                    <option value="1" @selected($week == '1')>Week 1</option>
                                    <option value="2" @selected($week == '2')>Week 2</option>
                                    <option value="3" @selected($week == '3')>Week 3</option>
                                    <option value="4" @selected($week == '4')>Week 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Tire Size</label>
                                <select class="form-control" name="tire_size">
                                    <option value="">Choose Tire Size</option>
                                    @foreach ($tire_sizes as $item)
                                        <option value="{{ $item->size }}" @selected($item->size == $tire_size)>
                                            {{ $item->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Brand Tire</label>
                                <select class="form-control" name="brand_tire">
                                    <option value="">Choose Brand Tire</option>
                                    @foreach ($manufacturer as $item)
                                        <option value="{{ $item->name }}" @selected($item->name == $brand_tire)>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Type Pattern</label>
                                <select class="form-control" name="type_pattern">
                                    <option value="">Choose Type Pattern</option>
                                    @foreach ($type_patterns as $item)
                                        <option value="{{ $item->type_pattern }}" @selected($item->type_pattern == $type_pattern)>
                                            {{ $item->type_pattern }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-sm-3 col-6">
                                <label>Tire Pattern</label>
                                <select class="form-control" name="tire_pattern">
                                    <option value="">Choose Tire Pattern</option>
                                    @foreach ($tire_patterns as $item)
                                        <option value="{{ $item->pattern }}" @selected($item->pattern == $tire_pattern)>
                                            {{ $item->pattern }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <h4 class="text-center">TYRE PERFORMANCE</h4>

    @if ($sum_lifetime_km)
    <div class="row">
        <div class="col-xl-12">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <h5>Average Lifetime KM
                        <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                            <i data-feather="maximize"></i>
                        </a>
                    </h5>
                </div>
                <div class="bar-chart-widget">
                    <div class="bottom-content card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="graphic-container">
                                    <div id="chart-tire-lifetime-scrap-km"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-lifetime-scrap-average-km'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($sum_lifetime_hm)
    <div class="row">
        <div class="col-xl-12">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <h5>Average Lifetime HM
                        <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                            <i data-feather="maximize"></i>
                        </a>
                    </h5>
                </div>
                <div class="bar-chart-widget">
                    <div class="bottom-content card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="graphic-container">
                                    <div id="chart-tire-lifetime-scrap-hm"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-lifetime-scrap-average-hm'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- <div class="row">
        <div class="col-xl-6">
            <div class="card o-hidden">
                <div class="card-header pb-0">
                    <h5>Tire COST BY HM PER PATTERN
                        <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                            <i data-feather="maximize"></i>
                        </a>
                    </h5>
                </div>
                <div class="bar-chart-widget">
                    <div class="bottom-content card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="graphic-container">
                                    <div id="chart-tire-cost-pattern-by-hm"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-cost-per-hm-by-pattern'), Request::fullUrl()) }}">
                                    </div>
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
                    <h5>Tire COST BY KM PER PATTERN
                        <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                            <i data-feather="maximize"></i>
                        </a>
                    </h5>
                </div>
                <div class="bar-chart-widget">
                    <div class="bottom-content card-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="chart-tire-cost-pattern-by-km"
                                    data-url="{{ str_replace(Request::url(), url('grafik-tire-cost-per-km-by-pattern'), Request::fullUrl()) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @push('js')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/dayjs.min.js" integrity="sha512-hcV6DX35BKgiTiWYrJgPbu3FxS6CsCjKgmrsPRpUPkXWbvPiKxvSVSdhWX0yXcPctOI2FJ4WP6N1zH+17B/sAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
         --}}
        <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
        <script src="{{ asset('assets\view\grafik-performance.js') }}"></script>

        <script>
            function toggleFullScreen(e) {
                elem = e.parentElement.parentElement.parentElement;
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
        </script>
    @endpush
</x-app-layout>
