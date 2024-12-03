<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Breakdown Unit</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Breakdown Unit</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal" data-post="new">
                <img src="assets/img/icons/plus.svg" alt="img" class="me-1">Import
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Tipe BD</th>
                            <th>Model</th>
                            <th>Code</th>
                            <th>Pit</th>
                            <th>Site</th>
                            <th>HM Breakdown</th>
                            <th>HM Ready</th>
                            <th>Start Breakdown Date</th>
                            <th>Start Breakdown</th>
                            <th>End Breakdown</th>
                            <th>Duration Breakdown</th>
                            <th>Status BD</th>
                            <th>Problem</th>
                            <th>Action</th>
                            <th>PB Vendor</th>
                            <th>MR RO PO</th>
                            <th>Section</th>
                            <th>Component</th>
                            <th>Manpowers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Breakdown Unit</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Breakdown Unit <span class="manitory">*</span></label>
                                    <input type="file" class="form-control" name="file" required>
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
        <script>
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('breakdown-unit.index') }}", // Sesuaikan dengan route untuk BreakdownUnit
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        {
                            data: 'shift',
                            name: 'shift'
                        },
                        {
                            data: 'tipe_bd',
                            name: 'tipe_bd'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'pit',
                            name: 'pit'
                        },
                        {
                            data: 'site.name',
                            name: 'site.name'
                        }, // Jika menggunakan relasi, sesuaikan dengan nama relasi
                        {
                            data: 'hm_bd',
                            name: 'hm_bd'
                        },
                        {
                            data: 'hm_ready',
                            name: 'hm_ready'
                        },
                        {
                            data: 'start_bd_date',
                            name: 'start_bd_date'
                        },
                        {
                            data: 'start_bd',
                            name: 'start_bd'
                        },
                        {
                            data: 'end_bd',
                            name: 'end_bd'
                        },
                        {
                            data: 'duration_bd',
                            name: 'duration_bd'
                        },
                        {
                            data: 'status_bd',
                            name: 'status_bd'
                        },
                        {
                            data: 'problem',
                            name: 'problem'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'pb_vendor',
                            name: 'pb_vendor'
                        },
                        {
                            data: 'mr_ro_po',
                            name: 'mr_ro_po'
                        },
                        {
                            data: 'section',
                            name: 'section'
                        },
                        {
                            data: 'component',
                            name: 'component'
                        },
                        {
                            data: 'manpowers',
                            name: 'manpowers'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            });

            $('#form-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var post = button.data('post');
                var modal = $(this);
                if (post == 'new') {
                    modal.find('input[name="_method"]').val('POST');
                    modal.find('form').attr('action', `{{ route('import') }}`);
                }
            });

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
