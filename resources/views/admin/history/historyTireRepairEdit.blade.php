<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Update Status To Spare </h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Repair</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('historytirerepair.update', $tire_repair->id) }}"
                enctype="multipart/form-data">
                <input type="hidden" name="tire_id">
                <input type="hidden" name="tire_status_id">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label>Site</label>
                            <input type="text" name="site">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="unit">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Serial Number</label>
                            <input type="text" name="serial_number">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Driver</label>
                            <input type="text" name="driver">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Tire Lifetime HM</label>
                            <input type="text" name="lifetime_hm">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>KM Unit</label>
                            <input type="text" name="km_unit">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" name="position">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>Tire Lifetime KM</label>
                            <input type="text" name="lifetime_km">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label>RTD</label>
                            <input type="text" name="rtd">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Man Power</label>
                            <input type="text">
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
                            <input type="text" name="reason ">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tire Damage<span class="manitory">*</span></label>
                            <select class="js-example-basic-multiple" id="tire_damage" name="tire_damage[]"
                                multiple="multiple">
                                @foreach ($tire_damages as $item)
                                    <option value="{{ $item->id }}"
                                        {{ in_array($item->id, $selectedDamages) ? 'selected' : '' }}>
                                        {{ $item->damage }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date"
                                value="{{ $tire_repair->start_date }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date"
                                value="{{ $tire_repair->end_date }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>PIC</label>
                            <input>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Tire Status Update</label>
                            <input type="text" name="tire_status" placeholder="SPARE" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_before_1" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_before_1)
                                    <img src="{{ asset('storage/uploads/before/' . $tire_repair->foto_before_1) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto Before 1</label>
                                <input type="file" class="foto-input" data-type="before" data-id="1"
                                    name="foto_before_1">
                                <input type="text" class="mt-2" name="keterangan_before_1" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_after_1" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_after_1)
                                    <img src="{{ asset('storage/uploads/after/' . $tire_repair->foto_after_1) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto After 1</label>
                                <input type="file" class="foto-input" data-type="after" data-id="1"
                                    name="foto_after_1">
                                <input type="text" class="mt-2" name="keterangan_after_1" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_before_2" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_before_2)
                                    <img src="{{ asset('storage/uploads/before/' . $tire_repair->foto_before_2) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto Before 2</label>
                                <input type="file" class="foto-input" data-type="before" data-id="2"
                                    name="foto_before_2">
                                <input type="text" class="mt-2" name="keterangan_before_2" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_after_2" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_after_2)
                                    <img src="{{ asset('storage/uploads/after/' . $tire_repair->foto_after_2) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto After 2</label>
                                <input type="file" class="foto-input" data-type="after" data-id="2"
                                    name="foto_after_2">
                                <input type="text" class="mt-2" name="keterangan_after_2" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_before_3" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_before_3)
                                    <img src="{{ asset('storage/uploads/before/' . $tire_repair->foto_before_3) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto Before 3</label>
                                <input type="file" class="foto-input" data-type="before" data-id="3"
                                    name="foto_before_3">
                                <input type="text" class="mt-2" name="keterangan_before_3" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="d-flex mb-3 overflow-hidden">
                            <div class="m-2 w-25 position-relative preview-foto" id="preview_after_3" style="height: 200px; background:gray; border-radius: 0.25rem; overflow:hidden;">
                                @if ($tire_repair->foto_after_3)
                                    <img src="{{ asset('storage/uploads/after/' . $tire_repair->foto_after_3) }}"/>
                                @endif
                            </div>
                            <div class="p-2 w-75 form-group">
                                <label>Foto After 3</label>
                                <input type="file" class="foto-input" data-type="after" data-id="3"
                                    name="foto_after_3">
                                <input type="text" class="mt-2" name="keterangan_after_3" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>

                </div>

                @if ($isTrue)
                    <button type="submit" class="btn btn-submit">Save</button>
                @endif
                <a href="{{ route('historytirerepair.index') }}" class="btn btn-cancel">Cancel</a>
            </form>
        </div>
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
                            img.style.height = '400px';
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
    @endpush
</x-app-layout>
