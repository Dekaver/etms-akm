<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>History Tire Repair</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> History Tire Repair</li>
                </ol>
            </nav>
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
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Brand</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Size</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Serial Number</th>
                            <th>Size</th>
                            <th>Pattern</th>
                            <th>Compound</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Man Power</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <!-- add Modal -->
    <div class="modal fade" id="form-modal-spare" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="tire_id">
            <input type="hidden" name="tire_status_id">
            <input type="hidden" name="history_tire_movement_id">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status To Spare </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Site</label>
                                    <input type="text" name="site" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" name="unit" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Driver</label>
                                    <input type="text" name="driver" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Tire Lifetime HM</label>
                                    <input type="text" name="lifetime_hm" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>KM Unit</label>
                                    <input type="text" name="km_unit" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Position</label>
                                    <input type="text" name="position" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tire Lifetime KM</label>
                                    <input type="text" name="lifetime_km" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" name="rtd" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Man Power</label>
                                    <input type="text" name="man_power">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Material</label>
                                    <input type="text" name="material">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Reason</label>
                                    <input type="text" name="reason">
                                </div>
                            </div>
                            {{-- <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Damage</label>
                                    <select name="tire_damage_id" class="form-control">
                                        <option value="">Select Damage</option>
                                        @foreach ($tire_damages as $item)
                                            <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Damage<span class="manitory">*</span></label>
                                    <select class="js-example-basic-multiple" id="tire_damage" name="tire_damage[]"
                                        multiple="multiple" limit="3">
                                        @foreach ($tire_damages as $item)
                                            <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d h:i') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d h:i') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" name="pic">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Status Update</label>
                                    <input type="text" name="tire_status" placeholder="SPARE" readonly>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto Before 1</label>
                                    <input type="file" class="foto-input" data-type="before" data-id="1"
                                        name="foto_before_1">
                                    <input class="mt-2" type="text" name="keterangan_before_1"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_before_1"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto After 1</label>
                                    <input type="file" class="foto-input" data-type="after" data-id="1"
                                        name="foto_after_1">
                                    <input class="mt-2" type="text" name="keterangan_after_1"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_after_1"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto Before 2</label>
                                    <input type="file" class="foto-input" data-type="before" data-id="2"
                                        name="foto_before_2">
                                    <input class="mt-2" type="text" name="keterangan_before_2"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_before_2"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto After 2</label>
                                    <input type="file" class="foto-input" data-type="after" data-id="2"
                                        name="foto_after_2">
                                    <input class="mt-2" type="text" name="keterangan_after_2"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_after_2"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto Before 3</label>
                                    <input type="file" class="foto-input" data-type="before" data-id="3"
                                        name="foto_before_3">
                                    <input class="mt-2" type="text" name="keterangan_before_3"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_before_3"></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label>Foto After 3</label>
                                    <input type="file" class="foto-input" data-type="after" data-id="3"
                                        name="foto_after_3">
                                    <input class="mt-2" type="text" name="keterangan_after_3"
                                        placeholder="Keterangan">
                                    <div class="mt-3" id="preview_after_3"></div>
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
            document.querySelectorAll('.foto-input').forEach(input => {
                input.addEventListener('change', function() {
                    const fileType = this.getAttribute('data-type'); // "before" or "after"
                    const fileId = this.getAttribute('data-id'); // "1", "2", "3", etc.
                    const previewContainerId = `preview_${fileType}_${fileId}`;
                    const previewContainer = document.getElementById(previewContainerId);

                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            // Clear the preview container
                            previewContainer.innerHTML = '';
                            // Create an img element and set its src to the selected file
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '100%'; // Set max width to fit the container
                            img.style.height = 'auto';
                            // Append the img to the preview container
                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').on('change', function() {
                    if ($(this).val().length > 3) {
                        alert('Anda hanya dapat memilih maksimal 3 item.');
                        // Menghapus seleksi terakhir jika pengguna memilih lebih dari 3 item
                        var selectedOptions = $(this).val();
                        selectedOptions.pop(); // Menghapus item terakhir dari array
                        $(this).val(selectedOptions).trigger(
                            'change'); // Memperbarui nilai dengan array yang dimodifikasi
                    }
                });
            });
        </script>

        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('historytirerepair.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'site',
                            name: 'site'
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
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'compound',
                            name: 'compound'
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
                            data: 'pic',
                            name: 'pic'
                        },
                        {
                            data: 'man_power',
                            name: 'man_power'
                        },
                        {
                            data: 'status',
                            name: 'status'
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

            $('#form-modal-spare').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)
                var id = button.data('id');
                $.ajax({
                    method: "GET",
                    url: `{{ route('historytirerepair.index') }}/${id}/edit`
                }).done(function(response) {
                    modal.find('input[name="man_power"]').val(response.man_power);
                    modal.find('input[name="foto_before_1"]').val(response.foto_before_1);
                    modal.find('input[name="keterangan_before_1"]').val(response.keterangan_before_1);
                    modal.find('input[name="material"]').val(response.material);
                    modal.find('input[name="reason"]').val(response.reason);
                    modal.find('input[name="pic"]').val(response.pic);
                    modal.find('input[name="driver"]').val(response.history_tire_movement.driver.nama);
                    modal.find('input[name="position"]').val(response.history_tire_movement.position);
                    modal.find('input[name="km_unit"]').val(response.history_tire_movement.km_unit);
                    modal.find('input[name="history_tire_movement_id"]').val(response.history_tire_movement.id);
                    modal.find('input[name="unit"]').val(response.history_tire_movement.unit_number.unit_number);
                    modal.find('input[name="site"]').val(response.history_tire_movement.site.name);
                    modal.find('input[name="serial_number"]').val(response.history_tire_movement.tire_number.serial_number);
                    modal.find('input[name="tire_id"]').val(response.history_tire_movement.tire_number.id);
                    modal.find('input[name="lifetime_hm"]').val(response.history_tire_movement.tire_number.lifetime_hm);
                    modal.find('input[name="lifetime_km"]').val(response.history_tire_movement.tire_number.lifetime_km);
                    modal.find('input[name="tire_status_id"]').val(response.history_tire_movement.tire_number.tire_status_id);
                    modal.find('input[name="rtd"]').val(response.history_tire_movement.tire_number.rtd);
                });
                modal.find('form').attr('action', `{{ route('historytirerepair.index') }}/${id}`)
            });

           
            $('#form-modal-spare').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
