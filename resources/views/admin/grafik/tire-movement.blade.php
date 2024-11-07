<x-app-layout>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter {{ request('tire_size') && request('tahun') ? 'setclose' : '' }}"
                                id="filter_search">
                                <img src="assets/img/icons/filter.svg" alt="img">
                                <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-path"
                            {{ request('tire_size') && request('tahun') ? 'style=display:block' : 'style=display:none' }}>
                            <a class="btn btn-filter bg-secondary" href="{{ Request::url() }}">
                                <img src="assets/img/icons/filterclear.svg" alt="img">
                            </a>
                        </div>
                        <div class="search-path">
                            <a class="btn btn-filter" onclick="document.getElementById('form-filter').submit()">
                                <img src="assets/img/icons/search-whites.svg" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="mt-3" id="filter_inputs"
                        {{ request('tire_size') && request('tahun') ? 'style=display:block' : '' }}>
                        <form action="" id="form-filter">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label>Tire Size</label>
                                        <select class="form-control" name="tire_size">
                                            <option value="">Choose Size</option>
                                            @foreach ($size as $item)
                                                <option value="{{ $item->name }}" @if(request('tire_size') == $item->name) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Conditional display for the chart --}}
    @if(request('tire_size') && request('tahun'))
        <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>MTD {{ request('tire_size') }} USSAGE
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-new-movement"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-new-movement'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4" role="alert">
            Please select both Tire Size and Year to display the chart.
        </div>
    @endif

    @push('js')
        <script src="{{ asset('assets/view/grafik-movement.js') }}"></script>
        <script>
            function toggleFullScreen(e) {
                elem = e.parentElement.parentElement.parentElement;
                if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || 
                    (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || 
                    (document.mozFullScreen !== undefined && !document.mozFullScreen) || 
                    (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
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
