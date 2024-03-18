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
                    {{-- <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">
                            <span><img src="{{ asset('assets/img/icons/closes.svg') }}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                alt="img"></a>
                    </div> --}}
                </div>
                {{-- <div class="wordset">
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
                </div> --}}
            </div>

            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Serial Number</th>
                            <th>Pos</th>
                            <th>Process</th>
                            <th>Status</th>
                            <th>Site</th>
                            <th>Unit</th>
                            <th>Tire HM</th>
                            <th>Tire KM</th>
                            <th>Unit HM</th>
                            <th>Unit KM</th>
                            <th>RTD</th>
                            <th>Driver</th>
                            <th>PIC</th>
                            <th>Man Power</th>
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
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            text: 'Export Excel',
                            filename: `History Tire Movement ${new Date().getTime()}`
                        },
                        'copy', 'csv'
                    ],
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('historytiremovement.tiremovement', $tire->id) }}",
                    columns: [{
                            data: 'start_date',
                            name: 'start_date'
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
                            data: 'process',
                            name: 'process'
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
                            data: 'hm_tire',
                            name: 'hm_tire'
                        },
                        {
                            data: 'km_tire',
                            name: 'km_tire'
                        },
                        {
                            data: 'hm_unit',
                            name: 'hm_unit'
                        },
                        {
                            data: 'km_unit',
                            name: 'km_unit'
                        },
                        {
                            data: 'rtd',
                            name: 'rtd'
                        },
                        {
                            data: 'driver',
                            name: 'driver'
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
                            data: 'damage',
                            name: 'damage'
                        },
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
