<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Unit Model</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Unit Model</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Unit Model</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal" data-post="new"><img
                    src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Data</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="assets/img/icons/filter.svg" alt="img">
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
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
                </div>
            </div> --}}
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tiresize">
                                                <option value="">Choose Size</option>
                                                @foreach ($tiresize as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $tiresize_id)>{{ $item->size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-filters ms-auto"><img
                                                src="assets/img/icons/search-whites.svg" alt="img"></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Brand</th>
                            <th>Unit Model</th>
                            <th>Model Type</th>
                            <th>Tire Size</th>
                            <th>Tire Quantity</th>
                            <th>Axle 2 Tire</th>
                            <th>Axle 4 Tire</th>
                            {{-- <th>Axle 8 Tire</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Unit Model </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Brand</label>
                                    <input type="text" name="brand">
                                </div>
                            </div>
                            <div class="col-lg-5 col-6">
                                <div class="form-group">
                                    <label>Unit Model</label>
                                    <input type="text" name="model">
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="form-group">
                                    <label>Model Type</label>
                                    <input type="text" name="type">
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="form-group">
                                    <label>Tire Size</label>
                                    <select class="select" name="tire_size_id">
                                        <option value="">Choose Size</option>
                                        @foreach ($tiresize as $item)
                                            <option value="{{ $item->id }}">{{ $item->size }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="form-group">
                                    <label>Tire Qty</label>
                                    <input class="form-control" value="0" type="number" name="tire_qty" readonly>
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="form-group">
                                    <label>Axle 2 Tire</label>
                                    <input class="form-control" value="0" type="number" name="axle_2_tire">
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="form-group">
                                    <label>Axle 4 Tire</label>
                                    <input class="form-control" value="0" type="number" name="axle_4_tire">
                                </div>
                            </div>
                            {{-- <div class="col-lg-2 col-3">
                                <div class="form-group">
                                    <label>Axle 8 Tire</label>
                                    <input class="form-control" value="0" type="number" name="axle_8_tire">
                                </div>
                            </div> --}}
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Load Distribution</label>
                                    <input type="text" name="distribusi_beban">
                                </div>
                            </div>
                            <div class="col-lg-5 col-6">
                                <div class="form-group">
                                    <label>Empty Weight Info</label>
                                    <input type="text" name="informasi_berat_kosong">
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="form-group">
                                    <label>Standar Load Capacity</label>
                                    <input type="text" name="standar_load_capacity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Save</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('js')
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
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
                            data: 'brand',
                            name: 'brand'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'tire_size',
                            name: 'tire_size'
                        },
                        {
                            data: 'tire_qty',
                            name: 'tire_qty'
                        },
                        {
                            data: 'axle_2_tire',
                            name: 'axle_2_tire'
                        },
                        {
                            data: 'axle_4_tire',
                            name: 'axle_4_tire'
                        },
                        {
                            data: 'action',
                            name: 'action',
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
                    modal.find('form').attr('action', `{{ route('unitmodel.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('unitmodel.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="name"]').val(response.name);
                        modal.find('input[name="brand"]').val(response.brand);
                        modal.find('input[name="model"]').val(response.model);
                        modal.find('input[name="type"]').val(response.type);
                        modal.find('input[name="tire_qty"]').val(response.tire_qty);
                        modal.find('input[name="axle_2_tire"]').val(response.axle_2_tire);
                        modal.find('input[name="axle_4_tire"]').val(response.axle_4_tire);
                        modal.find('input[name="axle_8_tire"]').val(response.axle_8_tire);
                        modal.find('input[name="informasi_berat_kosong"]').val(response.informasi_berat_kosong);
                        modal.find('input[name="distribusi_beban"]').val(response.distribusi_beban);
                        modal.find('input[name="standar_load_capacity"]').val(response.standar_load_capacity);
                        modal.find('select[name="tire_size_id"]').val(response.tire_size_id).trigger("change");
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('unitmodel.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="tire_size_id"]').trigger('change')
            });
            $("#form-modal input[name='axle_2_tire']").change(function(){
                var axle_2_tire_val =  $("#form-modal input[name='axle_2_tire']").val()
                var axle_4_tire_val =  $("#form-modal input[name='axle_4_tire']").val()
                var total_tire = (axle_2_tire_val * 2) + axle_4_tire_val * 4
                $("#form-modal input[name='tire_qty']").val(total_tire)
            })
            $("#form-modal input[name='axle_4_tire']").change(function(){
                var axle_2_tire_val =  $("#form-modal input[name='axle_2_tire']").val()
                var axle_4_tire_val =  $("#form-modal input[name='axle_4_tire']").val()
                var total_tire = (axle_2_tire_val * 2) + axle_4_tire_val * 4
                $("#form-modal input[name='tire_qty']").val(total_tire)
            })
        </script>
    @endpush
</x-app-layout>
