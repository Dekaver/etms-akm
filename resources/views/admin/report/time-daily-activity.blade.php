<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Daily Activity Time Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Daily Activity Time</li>
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
                            <th style="text-align: center" rowspan="2">Teknisi</th>
                            @foreach (range(1, 12) as $month)
                                <th style="text-align: center" colspan="2">
                                    {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach (range(1, 12) as $month)
                                <th style="text-align: center; background-color: #f8f9fa;">Total</th>
                                <th style="text-align: center; background-color: #f8f9fa;">Average</th>
                            @endforeach
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
                        filename: `Daily Activity Time Report ${new Date().getFullYear()}`
                    }],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('report.timedailyactivity') }}",
                        data: function(d) {
                            d.year = $('select[name="year"]').val(); // Add the selected year to the request
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error:", error);
                            alert("Terjadi kesalahan saat memuat data.");
                        }
                    },
                    columns: [{
                            data: 'teknisi',
                            name: 'teknisi'
                        },
                        @foreach (range(1, 12) as $month)
                            {
                                data: 'total{{ $month }}',
                                name: 'total{{ $month }}',
                                render: function(data, type, row) {
                                    return data !== undefined ? formatTime(data) : '00:00:000';
                                }
                            }, {
                                data: 'average{{ $month }}',
                                name: 'average{{ $month }}',
                                render: function(data, type, row) {
                                    return data !== undefined ? formatTime(data) : '00:00:000';
                                }
                            },
                        @endforeach
                    ],
                });

                // Function to format seconds to mm:ss:SSS
                function formatTime(totalSeconds) {
                    // Convert seconds to total milliseconds
                    const totalMilliseconds = Math.floor(totalSeconds * 1000);

                    // Calculate minutes, seconds, and milliseconds
                    const minutes = Math.floor(totalMilliseconds / 60000);
                    const secondsValue = Math.floor((totalMilliseconds % 60000) / 1000);
                    const milliseconds = totalMilliseconds % 1000;

                    // Format the time as mm:ss:SSS
                    return pad(minutes) + ":" + pad(secondsValue) + ":" + pad(milliseconds, 3);
                }

                // Helper function to pad numbers with leading zeros
                function pad(number, length = 2) {
                    return number.toString().padStart(length, '0');
                }

                $('#filter-form').on('submit', function(e) {
                    e.preventDefault();
                    table.ajax.reload();
                });
            });
        </script>
    @endpush
</x-app-layout>
