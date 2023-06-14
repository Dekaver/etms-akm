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
                {{-- <div class="wordset">
                    <ul>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                    src="assets/img/icons/pdf.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                    src="assets/img/icons/excel.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                    src="assets/img/icons/printer.svg" alt="img"></a>
                        </li>
                    </ul>
                </div> --}}
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
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>NEW</th>
                            <th>SPARE</th>
                            <th>RUNNING</th>
                            <th>REPAIR</th>
                            <th>SCRAP</th>
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
                    ajax: window.location.href,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'size',
                            name: 'size',
                        },
                        {
                            data: 'manufacture',
                            name: 'manufacture',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'new',
                            name: 'new',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'spare',
                            name: 'spare',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'running',
                            name: 'running',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'repair',
                            name: 'repair',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'scrap',
                            name: 'scrap',
                            orderable: false,
                            searchable: false
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
                        modal.find('input[name="target_lifetime"]').val(response.target_lifetime).trigger(
                            'change');
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
