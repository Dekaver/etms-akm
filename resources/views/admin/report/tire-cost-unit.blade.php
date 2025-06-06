<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Report</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Tire Cost By Unit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter {{ $tire_size ? ' setclose' : '' }}" id="filter_search">
                            <img src="assets/img/icons/filter.svg" alt="img">
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card mb-0" id="filter_inputs" {{ $tire_size ? 'style=display:block' : '' }}>
                <div class="card-body pb-0">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" name="start_date"
                                        value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" name="end_date"
                                        value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select" name="status">
                                        <option value="">Choose Status</option>
                                        <option value="SCRAP">SCRAP</option>
                                        <option value="NEW">NEW</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-filters ms-auto">
                                        <img src="assets/img/icons/search-whites.svg" alt="img">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Filter Form -->

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit Number</th>
                            <th>Brand</th>
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /Data Table -->
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: window.location.href,
                        data: function(d) {
                            d.status = $('select[name=status]').val();
                            d.start_date = $('input[name=start_date]').val();
                            d.end_date = $('input[name=end_date]').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'unit_number',
                            name: 'unit_number'
                        }, 
                        {
                            data: 'brand',
                            name: 'brand'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'manufaktur',
                            name: 'manufaktur'
                        },
                        {
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'type_pattern',
                            name: 'type_pattern'
                        },
                        {
                            data: 'qty',
                            name: 'qty'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        }
                    ]
                });

                // Refresh DataTable on form submission
                $('form').on('submit', function(e) {
                    e.preventDefault();
                    table.draw();
                });
            });
        </script>
    @endpush
</x-app-layout>
