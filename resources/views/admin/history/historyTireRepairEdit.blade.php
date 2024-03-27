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
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="tire_id">
                <input type="hidden" name="tire_status_id">
                <input type="hidden" name="history_tire_movement_id">
                @csrf
                @method('PUT')
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
                                {{-- @foreach ($tire_damages as $item)
                                    <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                @endforeach --}}
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

                <button type="submit" class="btn btn-submit">Save</button>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
</x-app-layout>
