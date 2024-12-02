<x-app-layout>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter {{ request('tahun') ? 'setclose' : '' }}" id="filter_search">
                                <img src="assets/img/icons/filter.svg" alt="img">
                                <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-path" {{ request('tahun') ? 'style=display:block' : 'style=display:none' }}>
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

                    <!-- Filter Inputs -->
                    <div class="mt-3" id="filter_inputs" {{ request('tahun') ? 'style=display:block' : '' }}>
                        <form action="" id="form-filter">
                            <div class="row">
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

    <!-- Conditional display for the chart -->
    @if (request('tahun'))
        <div class="row">
            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Lead Time JOB for Year {{ request('tahun') }}
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-lead-time-job"
                                        data-url="{{ route('grafik-lead-time-job', ['tahun' => request('tahun')]) }}">
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
            Please select a Year to display the chart.
        </div>
    @endif

    @push('js')
        <script src="{{ asset('assets/view/grafik-lead-time-job.js') }}"></script>
    @endpush
</x-app-layout>
