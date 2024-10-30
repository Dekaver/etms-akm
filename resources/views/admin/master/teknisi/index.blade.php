<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Teknisi</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Teknisi</li>
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
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Department</th>
                            <th>Jabatan</th>
                            <th>Perusahaan</th>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Teknisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" name="nik">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="kode" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama Teknisi<span class="manitory">*</span></label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Department<span class="manitory">*</span></label>
                                    <select class="form-select" name="department_id" required>
                                        <option value="">Choose Department</option>
                                        @foreach ($department as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($department_id ?? ''))>
                                                {{ $item->department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Jabatan<span class="manitory">*</span></label>
                                    <select class="form-select" name="jabatan_id" required>
                                        <option value="">Choose Jabatan</option>
                                        @foreach ($jabatan as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($jabatan_id ?? ''))>
                                                {{ $item->jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Company<span class="manitory">*</span></label>
                                    <select class="form-select" name="company_id" required>
                                        <option value="">Choose Company</option>
                                        @foreach ($company as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($company_id ?? ''))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="inputcheck">PIC Leader
                                    <input type="checkbox" name="is_leader">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="inputcheck">Foreman
                                    <input type="checkbox" name="is_foreman">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="inputcheck">PIC Man Power
                                    <input type="checkbox" name="is_manpower">
                                    <span class="checkmark"></span>
                                </label>
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
                    serverSide: false,
                    ajax: "{{ route('teknisi.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'kode',
                            name: 'kode'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'department',
                            name: 'department'
                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan'
                        },
                        {
                            data: 'company',
                            name: 'company'
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
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var modal = $(this);

                if (button.data('post') === 'new') {
                    // Set default values for a new entry
                    modal.find('form').attr('action', `{{ route('teknisi.store') }}`);
                    modal.find('input[name="_method"]').val('POST');
                    modal.find('select[name="department_id"]').val('');
                    modal.find('select[name="jabatan_id"]').val('');
                    modal.find('select[name="company_id"]').val('');
                    modal.find('input[name="is_leader"]').prop('checked', false);
                    modal.find('input[name="is_foreman"]').prop('checked', false);
                    modal.find('input[name="is_manpower"]').prop('checked', false);
                } else {
                    // Fetch and fill data for editing
                    $.ajax({
                        method: "GET",
                        url: `{{ route('teknisi.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="nama"]').val(response.nama);
                        modal.find('input[name="kode"]').val(response.kode);
                        modal.find('input[name="nik"]').val(response.nik);
                        modal.find('select[name="department_id"]').val(response.department_id);
                        modal.find('select[name="jabatan_id"]').val(response.jabatan_id);
                        modal.find('select[name="company_id"]').val(response.company_id);
                        modal.find('form').attr('action', `{{ route('teknisi.update', '') }}/${id}`);
                        modal.find('input[name="_method"]').val('PUT');

                        // Set checkbox values based on response, enforcing boolean interpretation
                        modal.find('input[name="is_leader"]').prop('checked', Boolean(response.is_leader));
                        modal.find('input[name="is_foreman"]').prop('checked', Boolean(response.is_foreman));
                        modal.find('input[name="is_manpower"]').prop('checked', Boolean(response.is_manpower));
                    });
                }
            });

            $('#form-modal').on('hide.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('select').val('');
                $(this).find('input[type="checkbox"]').prop('checked', false);
            });
        </script>
    @endpush
</x-app-layout>
