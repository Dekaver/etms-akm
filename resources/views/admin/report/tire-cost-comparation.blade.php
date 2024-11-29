<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Cost Comparison Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
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
            <form id="filter-form">
                <div class="row">
                    <div class="form-group col-lg-3 col-sm-3 col-6">
                        <label>Year</label>
                        <select class="form-control" name="year">
                            <option value="" disabled selected>Choose Year</option>
                            @for ($i = 2022; $i <= now()->year; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
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
                                <th style="text-align: center" colspan="3">
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </th>
                            @endforeach
                            <th style="text-align: center" colspan="3">Total</th>
                        </tr>
                        <tr>
                            @foreach (range(1, 12) as $month)
                                <th style="text-align: center; background-color: #f8f9fa;">Forecast</th>
                                <th style="text-align: center; background-color: #f8f9fa;">Actual</th>
                                <th style="text-align: center;">Result</th>
                            @endforeach
                            <th style="text-align: center; background-color: #37474F; color: white;">Forecast</th>
                            <!-- Blue-Grey -->
                            <th style="text-align: center; background-color: #546E7A; color: white;">Actual</th>
                            <!-- Light Blue-Grey -->
                            <th style="text-align: center; background-color: #FFC107; color: black;">Result</th>
                            <!-- Soft Yellow -->

                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this section -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
    @endpush

    @push('js')
        <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
        <script>
            $(function() {
                const table = $('.data-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        filename: `Tire Cost Comparison Report ${new Date().getFullYear()}`
                    }],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('report.tirecostcomparation') }}",
                        data: function(d) {
                            d.year = $('select[name="year"]').val(); // Menambahkan parameter tahun
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error:", error);
                            alert("Terjadi kesalahan saat memuat data.");
                        }
                    },
                    columns: [{
                            data: 'unit',
                            name: 'unit'
                        },
                        @foreach (range(1, 12) as $month)
                            {
                                data: 'forecast{{ $month }}',
                                name: 'forecast{{ $month }}',
                                render: $.fn.dataTable.render.number(',', '.', 0)
                            }, {
                                data: 'realized{{ $month }}',
                                name: 'realized{{ $month }}',
                                render: $.fn.dataTable.render.number(',', '.', 0)
                            }, {
                                data: 'result{{ $month }}',
                                name: 'result{{ $month }}',
                                render: $.fn.dataTable.render.number(',', '.', 0),
                                createdCell: function(td, cellData) {
                                    if (cellData > 0) {
                                        $(td).css({
                                            backgroundColor: '#28a745',
                                            color: 'white'
                                        }); // Positive: Green
                                    } else if (cellData < 0) {
                                        $(td).css({
                                            backgroundColor: '#dc3545',
                                            color: 'white'
                                        }); // Negative: Red
                                    } else {
                                        $(td).css({
                                            backgroundColor: '#ffc107',
                                            color: 'white'
                                        }); // Neutral: Yellow
                                    }
                                }
                            },
                        @endforeach {
                            data: 'total_forecast',
                            name: 'total_forecast',
                            render: $.fn.dataTable.render.number(',', '.', 0)
                        },
                        {
                            data: 'total_realized',
                            name: 'total_realized',
                            render: $.fn.dataTable.render.number(',', '.', 0)
                        },
                        {
                            data: 'result',
                            name: 'result',
                            render: $.fn.dataTable.render.number(',', '.', 0),
                            createdCell: function(td, cellData) {
                                if (cellData > 0) {
                                    $(td).css({
                                        backgroundColor: '#28a745',
                                        color: 'white'
                                    }); // Positive: Green
                                } else if (cellData < 0) {
                                    $(td).css({
                                        backgroundColor: '#dc3545',
                                        color: 'white'
                                    }); // Negative: Red
                                } else {
                                    $(td).css({
                                        backgroundColor: '#6c757d',
                                        color: 'white'
                                    }); // Neutral: Gray
                                }
                            }
                        }
                    ],
                    columnDefs: [{
                            targets: -3,
                            className: 'text-center font-weight-bold',
                            createdCell: (td) => $(td).css({
                                backgroundColor: '#37474F',
                                color: 'white'
                            })
                        },
                        {
                            targets: -2,
                            className: 'text-center font-weight-bold',
                            createdCell: (td) => $(td).css({
                                backgroundColor: '#546E7A',
                                color: 'white'
                            })
                        },
                        {
                            targets: -1,
                            className: 'text-center font-weight-bold',
                            createdCell: (td) => $(td).css({
                                backgroundColor: '#06b2c8',
                                color: 'white'
                            })
                        },
                    ]
                });
                
                $('#filter-form').on('submit', function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                }); 
            });
        </script>
    @endpush
</x-app-layout>
