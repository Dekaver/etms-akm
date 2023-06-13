<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>History Tire</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">History</li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Movement</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                            <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
                    <ul>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                    src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                    src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                    src="{{ asset('assets/img/icons/printer.svg') }}" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Site</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Size</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Serial Number</th>
                            <th>Pos</th>
                            <th>Status</th>
                            <th>Site</th>
                            <th>Unit</th>
                            <th>Tire HM</th>
                            <th>Tire KM</th>
                            <th>Unit HM</th>
                            <th>Unit KM</th>
                            <th>RTD</th>
                            <th>PIC</th>
                            <th>Man Power</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('historytiremovement.tiremovement', $tire->id) }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tire',
                            name: 'tire'
                        },
                        {
                            data: 'position',
                            name: 'position'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'site',
                            name: 'site'
                        },
                        {
                            data: 'unit',
                            name: 'unit'
                        },
                        {
                            data: 'tire_hm',
                            name: 'tire_hm'
                        },
                        {
                            data: 'tire_km',
                            name: 'tire_km'
                        },
                        {
                            data: 'unit_hm',
                            name: 'unit_hm'
                        },
                        {
                            data: 'unit_km',
                            name: 'unit_km'
                        },
                        {
                            data: 'rtd',
                            name: 'rtd'
                        },
                        {
                            data: 'pic',
                            name: 'pic'
                        },
                        {
                            data: 'pic_man_power',
                            name: 'pic_man_power'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                    ]
                });


            });
        </script>
    @endpush
</x-app-layout>
