<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Cost Comparison Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Cost Comparison</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-header pb-0">
            <h5>Filter Options</h5>
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="form-group col-lg-3 col-sm-3 col-6">
                        <label>Year</label>
                        <select class="form-control" name="year">
                            <option value="">Choose Year</option>
                            @for ($i = 2022; $i <= now()->year; $i++)
                                <option value="{{ $i }}" {{ isset($year) && $year == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Apply Filters</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th style="text-align: center" rowspan="2">Unit</th>
                            @foreach (range(1, 12) as $month)
                                <th style="text-align: center" colspan="2">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</th>
                            @endforeach
                            <th style="text-align: center" colspan="2">Total</th>
                        </tr>
                        <tr>
                            @foreach (range(1, 12) as $month)
                                <th style="text-align: center">Forecast</th>
                                <th style="text-align: center">Realized</th>
                            @endforeach
                            <th style="text-align: center; background-color: #0d6efd;" class="text-white">Forecast</th>
                            <th style="text-align: center; background-color: #dc3545;" class="text-white">Realized</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this section via AJAX -->
                    </tbody>
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
                // Helper function to format numbers with commas as thousand separators
                function formatNumber(num) {
                    return num ? num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : "0";
                }

                var table = $('.data-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Export Excel',
                            filename: `Tire Cost Comparison Report ${new Date().getFullYear()}`
                        },
                        'copy', 'csv'
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('report.tirecostcomparation') }}",
                        data: function(d) {
                            d.year = $('select[name="year"]').val();
                        }
                    },
                    columns: [
                        { data: 'unit', name: 'unit' },
                        @foreach (range(1, 12) as $month)
                            { data: 'forecast{{ $month }}', name: 'forecast{{ $month }}', render: $.fn.dataTable.render.number(',', '.', 0) },
                            { data: 'realized{{ $month }}', name: 'realized{{ $month }}', render: $.fn.dataTable.render.number(',', '.', 0) },
                        @endforeach
                        { data: 'total_forecast', name: 'total_forecast', render: $.fn.dataTable.render.number(',', '.', 0) },
                        { data: 'total_realized', name: 'total_realized', render: $.fn.dataTable.render.number(',', '.', 0) }
                    ],
                    columnDefs: [
                        {
                            targets: -2,
                            className: 'text-center font-weight-bold',
                            createdCell: function (td) { $(td).css('background-color', '#0d6efd').css('color', 'white'); }
                        },
                        {
                            targets: -1,
                            className: 'text-center font-weight-bold',
                            createdCell: function (td) { $(td).css('background-color', '#dc3545').css('color', 'white'); }
                        }
                    ]
                });

                // Refresh the table data when the filter form is submitted
                $('form').on('submit', function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                });
            });
        </script>
    @endpush
</x-app-layout>
