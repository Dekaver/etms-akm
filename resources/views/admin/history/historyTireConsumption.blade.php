<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>History Tire Consumption</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">History</li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Consumption</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">

        <!-- /Filter -->
        <div class="card-header pb-0">
            <h5>Filter</h5>
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="form-group col-lg-3 col-sm-3 col-6">
                        <label>Group</label>
                        <select class="form-control" name="grup">
                            <option value="">Choose Group</option>
                            <option value="unit" @selected($grup == 'unit')>Unit</option>
                            <option value="driver" @selected($grup == 'driver')>Driver</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-3 col-sm-3 col-6">
                        <label>Year</label>
                        {{-- <input class="form-control" type="text" name="tahun" max="9999" min="2000"
                                maxlength="4" value="{{ $tahun }}"> --}}
                        <select class="select" name="year">
                            <option value="">Choose Years</option>
                            @for ($i = 2022; $i < \Carbon\Carbon::now()->format('Y') + 1; $i++)
                                <option value="{{ $i }}" @selected($year == $i)>
                                    {{ $i }}</option>
                            @endfor
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
                </div>
                <div class="row">

                    <div class="form-group col-lg-2 col-sm-2 col-6">
                        <label>Unit</label>
                        <select class="form-control" name="unit">
                            <option value="">Choose Unit</option>
                            @foreach ($units as $item)
                                <option value="{{ $item->unit_number }}" @selected($item->unit_number == $unit)>
                                    {{ $item->unit_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-2 col-sm-2 col-6">
                        <label>Tire Size</label>
                        <select class="form-control" name="tire_size">
                            <option value="">Choose Tire Size</option>
                            @foreach ($tire_sizes as $item)
                                <option value="{{ $item->size }}" @selected($item->size == $tire_size)>
                                    {{ $item->size }}</option>
                            @endforeach
                        </select>
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
                        <label>Type Pattern</label>
                        <select class="form-control" name="type_pattern">
                            <option value="">Choose Type Pattern</option>
                            @foreach ($type_patterns as $item)
                                <option value="{{ $item->type_pattern }}" @selected($item->type_pattern == $type_pattern)>
                                    {{ $item->type_pattern }}</option>
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
                        <label>Driver</label>
                        <select class="form-control" name="driver">
                            <option value="">Choose Driver</option>
                            @foreach ($drivers as $item)
                                <option value="{{ $item->id }}" @selected($item->id == $driver)>
                                    {{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        @php
                            setlocale(LC_TIME, 'id_ID', 'Indonesian_Indonesia', 'Indonesian'); // Menyesuaikan dengan sistem Anda
                            $monthName = strftime('%B', mktime(0, 0, 0, $month, 10)); // Menggunakan mktime untuk mendapatkan string bulan
                        @endphp
                        <tr>
                            <th style="text-align: center" class="text-center" colspan="18">{{ $monthName }}
                                {{ $year }}</th>
                        </tr>
                        <tr>
                            @if ($grup == 'driver')
                                <th style="text-align: center" rowspan="2">Driver</th>
                            @else
                                <th style="text-align: center" rowspan="2">Unit</th>
                            @endif
                            <th style="text-align: center" colspan="3">Week 1</th>
                            <th style="text-align: center" colspan="3">Week 2</th>
                            <th style="text-align: center" colspan="3">Week 3</th>
                            <th style="text-align: center" colspan="3">Week 4</th>
                            <th style="text-align: center" colspan="3">Total</th>
                            <th style="text-align: center;" rowspan="2">Total</th>
                            <th style="text-align: center;" rowspan="2">Cost</th>

                        </tr>
                        <tr>
                            <th style="text-align: center">New</th>
                            <th style="text-align: center">Spare</th>
                            <th style="text-align: center">Scrap</th>
                            <th style="text-align: center">New</th>
                            <th style="text-align: center">Spare</th>
                            <th style="text-align: center">Scrap</th>
                            <th style="text-align: center">New</th>
                            <th style="text-align: center">Spare</th>
                            <th style="text-align: center">Scrap</th>
                            <th style="text-align: center">New</th>
                            <th style="text-align: center">Spare</th>
                            <th style="text-align: center">Scrap</th>
                            <th style="text-align: center; background : #0d6efd;" class="text-white">New</th>
                            <th style="text-align: center; background : #ffc107;" class="text-dark">Spare</th>
                            <th style="text-align: center; background : #dc3545;" class="text-white">Scrap</th>
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
                    ajax: window.location.href,
                    columns: [{
                        data: 'unit',
                        name: 'unit'
                    }, {
                        data: 'new1',
                        name: 'new1'
                    }, {
                        data: 'spare1',
                        name: 'spare1'
                    }, {
                        data: 'scrap1',
                        name: 'scrap1'
                    }, {
                        data: 'new2',
                        name: 'new2'
                    }, {
                        data: 'spare2',
                        name: 'spare2'
                    }, {
                        data: 'scrap2',
                        name: 'scrap2'
                    }, {
                        data: 'new3',
                        name: 'new3'
                    }, {
                        data: 'spare3',
                        name: 'spare3'
                    }, {
                        data: 'scrap3',
                        name: 'scrap3'
                    }, {
                        data: 'new4',
                        name: 'new4'
                    }, {
                        data: 'spare4',
                        name: 'spare4'
                    }, {
                        data: 'scrap4',
                        name: 'scrap4'
                    }, {
                        data: 'totalnew',
                        name: 'totalnew'
                    }, {
                        data: 'totalspare',
                        name: 'totalspare'
                    }, {
                        data: 'totalscrap',
                        name: 'totalscrap'
                    }, {
                        data: 'total',
                        name: 'total'
                    }, {
                        data: 'price',
                        name: 'price'
                    }],
                    columnDefs: [{
                            targets: [13], // Indeks kolom yang ingin Anda beri warna
                            render: function(data, type, row, meta) {
                                return '<div class="text-center text-white" style="background-color: #0d6efd; margin: -10px!important; padding: 10px 0;">' +
                                    data +
                                    '</div>'; // Warna hijau\
                            }
                        },
                        {
                            targets: [14], // Indeks kolom yang ingin Anda beri warna
                            render: function(data, type, row, meta) {
                                return '<div class="text-center text-dark" style="background-color: #ffc107; margin: -10px!important; padding: 10px 0;">' +
                                    data +
                                    '</div>'; // Warna hijau\
                            }
                        },
                        {
                            targets: [15], // Indeks kolom yang ingin Anda beri warna
                            render: function(data, type, row, meta) {
                                return '<div class="text-center text-white" style="background-color: #dc3545; margin: -10px!important; padding: 10px 0;">' +
                                    data +
                                    '</div>'; // Warna hijau\
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
