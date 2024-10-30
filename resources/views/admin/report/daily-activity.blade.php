<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Daily Activity</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daily Activity</li>
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
                            <th>Tanggal</th>
                            <th>Site</th>
                            <th>Area</th>
                            <th>Teknisi</th>
                            <th>Aktivitas</th>
                            <th>Unit Model</th>
                            <th>Unit</th>
                            <th>Waktu Mulai</th>
                            <th>Waktu Akhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Daily Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tanggal<span class="manitory">*</span></label>
                                    <input type="date" name="tanggal" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Job Site<span class="manitory">*</span></label>
                                    <select class="form-select" name="site_id" required>
                                        <option value="">Choose Job Site</option>
                                        @foreach ($site as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($site_id ?? ''))>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Area Pekerjaan<span class="manitory">*</span></label>
                                    <select class="form-select" name="area_pekerjaan_id" required>
                                        <option value="">Choose Area Pekerjaan</option>
                                        @foreach ($areaPekerjaan as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($areaPekerjaan_id ?? ''))>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Teknisi</label>
                                    <select class="form-select" name="teknisi_id" required>
                                        <option value="">Choose Teknisi</option>
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($teknisi_id ?? ''))>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Aktivitas Pekerjaan<span class="manitory">*</span></label>
                                    <select class="form-select" name="aktivitas_pekerjaan_id" id="aktivitasPekerjaan"
                                        required>
                                        <option value="">Choose Aktivitas Pekerjaan</option>
                                        @foreach ($aktivitasPekerjaan as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($aktivitas_pekerjaan_id ?? ''))>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Unit Model</label>
                                    <select class="form-select" name="unit_model_id" id="unitModel" required>
                                        <option value="">Choose Model</option>
                                        @foreach ($unitModel as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($unitModel_id ?? ''))>
                                                {{ $item->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select class="form-select" name="unit_id" id="unit" required>
                                        <option value="">Choose Unit</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($unit_id ?? ''))>
                                                {{ $item->unit_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Mulai Pekerjaan<span class="manitory">*</span></label>
                                    <input type="datetime-local" name="start_date" class="form-control" required
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Selesai Pekerjaan<span class="manitory">*</span></label>
                                    <input type="datetime-local" name="end_date" class="form-control" required
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Remark (Keterangan)<span class="manitory">*</span></label>
                                    <textarea name="remark" required rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <div id="existing-photos" class="d-flex flex-wrap gap-2"></div>
                                    <label>Upload Photos<span class="manitory">*</span></label>

                                    <input type="file" name="photos[]" class="form-control" multiple>
                                    <small class="text-muted">You can upload multiple photos.</small>
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
            document.getElementById('aktivitasPekerjaan').addEventListener('change', function() {
                const selectedValue = parseInt(this.value);
                const unitModel = document.getElementById('unitModel');
                const unit = document.getElementById('unit');

                if (selectedValue >= 1 && selectedValue <= 5) {
                    unitModel.setAttribute('required', 'required');
                    unit.setAttribute('required', 'required');
                } else {
                    unitModel.removeAttribute('required');
                    unit.removeAttribute('required');
                }
            });
        </script>
        <script>
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('daily-activity.index') }}",
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
                            data: 'site',
                            name: 'site'
                        },
                        {
                            data: 'area',
                            name: 'area'
                        },
                        {
                            data: 'teknisi',
                            name: 'teknisi'
                        },
                        {
                            data: 'aktivitas',
                            name: 'aktivitas'
                        },
                        {
                            data: 'unit_model',
                            name: 'unit_model'
                        },
                        {
                            data: 'unit',
                            name: 'unit'
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
                    // Mode Tambah: Bersihkan gambar yang ada
                    $('#existing-photos').html('');
                    modal.find('form').attr('action', `{{ route('daily-activity.store') }}`);
                    modal.find('input[name="_method"]').val('POST');
                } else {
                    // Mode Edit: Ambil data dari server
                    $.ajax({
                        method: "GET",
                        url: `{{ route('daily-activity.index') }}/${id}/edit`
                    }).done(function(response) {
                        // Menampilkan gambar yang sudah ada
                        let photosHtml = '';
                        response.gambars.forEach(gambar => {
                            photosHtml += `
                            <div class="existing-photo">
                                <img src="/storage/${gambar.gambar}" alt="photo" style="max-height: 150px; width: auto;">
                            </div>`;
                        });
                        $('#existing-photos').html(photosHtml);

                        // Isi form dengan data yang ada
                        modal.find('input[name="tanggal"]').val(response.tanggal);
                        modal.find('select[name="site_id"]').val(response.site_id);
                        modal.find('select[name="area_pekerjaan_id"]').val(response.area_pekerjaan_id);
                        modal.find('select[name="teknisi_id"]').val(response.teknisi_id);
                        modal.find('select[name="aktivitas_pekerjaan_id"]').val(response.aktivitas_pekerjaan_id);
                        modal.find('select[name="unit_model_id"]').val(response.unit_model_id);
                        modal.find('select[name="unit_id"]').val(response.unit_id);
                        modal.find('input[name="start_date"]').val(response.start_date);
                        modal.find('input[name="end_date"]').val(response.end_date);
                        modal.find('textarea[name="remark"]').val(response.remark);

                        // Set form action untuk update
                        modal.find('form').attr('action', `{{ route('daily-activity.update', '') }}/${id}`);
                        modal.find('input[name="_method"]').val('PUT');


                        const unitModel = document.getElementById('unitModel');
                        const unit = document.getElementById('unit');

                        if (response.aktivitas_pekerjaan_id >= 1 && response.aktivitas_pekerjaan_id <= 5) {
                            unitModel.setAttribute('required', 'required');
                            unit.setAttribute('required', 'required');
                        } else {
                            unitModel.removeAttribute('required');
                            unit.removeAttribute('required');
                        }
                    });
                }
            });

            $('#form-modal').on('hide.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#existing-photos').html(''); // Kosongkan gambar saat modal ditutup
            });
        </script>
    @endpush
</x-app-layout>
