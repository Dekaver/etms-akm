<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Report</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Report Total Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Tire Status By Size</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter {{ $tire_pattern || $tire_manufacture || $tire_size ? ' setclose' : '' }}"
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
                {{ $tire_pattern || $tire_manufacture || $tire_size || $type_pattern ? 'style=display:block' : '' }}>
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
                            <th>Serial number</th>
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Damage</th>
                            <th>HM</th>
                            <th>KM</th>
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
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number'
                        },
                        {
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'manufacture',
                            name: 'manufacture'
                        },
                        {
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'damage',
                            name: 'damage'
                        },
                        {
                            data: 'lifetime_hm',
                            name: 'lifetime_hm',
                            className: 'text-right'
                        },
                        {
                            data: 'lifetime_km',
                            name: 'lifetime_km',
                            className: 'text-right'
                        },

                    ]
                });


            });

            $('#form-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)
                if (post == 'new') {
                    modal.find('input[name="_method"]').val('POST');
                    modal.find('form').attr('action', `{{ route('tiresize.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tiresize.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="size"]').val(response.size).trigger('change');
                        modal.find('select[name="tire_pattern_id"]').val(response.tire_pattern_id).trigger(
                            'change');
                        modal.find('input[name="otd"]').val(response.otd).trigger('change');
                        modal.find('input[name="recomended_pressure"]').val(response.recomended_pressure)
                            .trigger('change');
                        modal.find('input[name="target_lifetime_hm"]').val(response.target_lifetime_hm);
                        modal.find('input[name="target_lifetime_km"]').val(response.target_lifetime_km);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tiresize.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
