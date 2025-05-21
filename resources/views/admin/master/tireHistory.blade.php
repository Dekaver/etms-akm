<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Last Tire</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Tire Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Last Tire</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>Site</th>
                            <th>Driver</th>
                            <th>Damage</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>HM Tire</th>
                            <th>KM Tire</th>
                            <th>HM Unit</th>
                            <th>KM Unit</th>
                            <th>RTD</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Scrap Tire</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="id">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>HM Tire</label>
                                <input type="number" name="hm_tire" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>KM Tire</label>
                                <input type="number" name="km_tire" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>KM Unit</label>
                                <input type="number" name="km_unit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>HM Unit</label>
                                <input type="number" name="hm_unit" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>RTD</label>
                                <input type="number" name="rtd" step="0.01" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="price" class="form-control">
                            </div>
                        </div>
                        {{-- Tambah field lainnya sesuai kebutuhan --}}
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
                let table = $('.data-table').DataTable({
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
                            data: 'type_pattern',
                            name: 'type_pattern'
                        },
                        {
                            data: 'site',
                            name: 'site'
                        },
                        {
                            data: 'driver',
                            name: 'driver'
                        },
                        {
                            data: 'damage',
                            name: 'damage'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
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
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'id',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `<a href="#" class="btn btn-sm btn-primary edit-btn" data-id="${data}">Edit</a>`;
                            }
                        }
                    ]
                });

                $(document).on('click', '.edit-btn', function(e) {
                    e.preventDefault();
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/historytiremovement/${id}/edit`,
                        method: 'GET',
                        success: function(res) {
                            const modal = $('#edit-modal');

                            const formatDate = val => {
                                if (!val) return '';
                                const date = new Date(val);
                                const year = date.getFullYear();
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const day = String(date.getDate()).padStart(2, '0');
                                return `${year}-${month}-${day}`;
                            };

                            modal.find('input[name="id"]').val(res.id);
                            modal.find('input[name="rtd"]').val(res.rtd);
                            modal.find('input[name="hm_tire"]').val(res.hm_tire);
                            modal.find('input[name="km_tire"]').val(res.km_tire);
                            modal.find('input[name="hm_unit"]').val(res.hm_unit);
                            modal.find('input[name="km_unit"]').val(res.km_unit);
                            modal.find('input[name="price"]').val(res.price);
                            modal.find('input[name="start_date"]').val(formatDate(res.start_date));
                            modal.find('input[name="end_date"]').val(formatDate(res.end_date));

                            modal.find('form').attr('action', `/historytiremovement/${res.id}`);
                            modal.modal('show');
                        }

                    });
                });

                $('#edit-modal').on('hide.bs.modal', function() {
                    $(this).find('form')[0].reset();
                });
            });
        </script>
    @endpush
</x-app-layout>
