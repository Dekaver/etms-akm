<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Report</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Report Tire Running</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Tire Tire Running</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter {{ $tire_pattern || $tire_manufacture || $tire_size || $tire_status ? ' setclose' : '' }}"
                            id="filter_search">
                            <img src="assets/img/icons/filter.svg" alt="img">
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs"
                {{ $tire_pattern || $tire_manufacture || $tire_size || $type_pattern || $tire_status ? 'style=display:block' : '' }}>
                <div class="card-body pb-0">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_pattern">
                                        <option value="">Choose Pattern</option>
                                        @foreach ($tire_patterns as $item)
                                            <option value="{{ $item->pattern }}" @selected($item->pattern == $tire_pattern)>
                                                {{ $item->pattern }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_manufacture">
                                        <option value="">Choose Manufacture</option>
                                        @foreach ($tire_manufactures as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == $tire_manufacture)>
                                                {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_size">
                                        <option value="">Choose Size</option>
                                        @foreach ($tire_sizes as $item)
                                            <option value="{{ $item->size }}" @selected($item->size == $tire_size)>
                                                {{ $item->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_status">
                                        <option value="">Choose Satatus</option>
                                        @foreach ($tire_statuses as $item)
                                            <option value="{{ $item->status }}" @selected($item->status == $tire_status)>
                                                {{ $item->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="type_pattern">
                                        <option value="">Choose Type</option>
                                        <option value="LUG" @selected('LUG' == $type_pattern)>LUG</option>
                                        <option value="MIX" @selected('MIX' == $type_pattern)>MIX</option>
                                        <option value="RIB" @selected('RIB' == $type_pattern)>RIB</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12">
                                <div class="form-group">
                                    <button class="btn btn-filters ms-auto"><img
                                            src="assets/img/icons/search-whites.svg" alt="img"></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Table -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Serial Number</th>
                            <th>Pos</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Manufacture Type</th>
                            <th>Site</th>
                            <th>Tire HM</th>
                            <th>Tire KM</th>
                            <th>RTD</th>
                            <th>Damage</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
    @endpush
    @push('js')
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jszip.min.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    dom: 'Bfrtlip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Export Excel',
                            filename: `Tire Running ${new Date().getTime()}`
                        },
                        'copy', 'csv'
                    ],
                    processing: true,
                    serverSide: false,
                    order: [
                        [3, 'asc']
                    ],
                    ajax: window.location.href,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number',
                        },
                        {
                            data: 'position',
                            name: 'position',
                        },
                        {
                            data: 'unit_number',
                            name: 'unit_number',
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'manufacture_pattern',
                            name: 'manufacture_pattern'
                        },
                        {
                            data: 'site_name',
                            name: 'site_name',
                        },
                        {
                            data: 'lifetime_hm',
                            name: 'lifetime_hm',
                        },
                        {
                            data: 'lifetime_km',
                            name: 'lifetime_km',
                        },
                        {
                            data: 'rtd',
                            name: 'rtd',
                        },
                        {
                            data: 'damage',
                            name: 'damage',
                        },
                    ]
                });


            });
        </script>
    @endpush
</x-app-layout>
