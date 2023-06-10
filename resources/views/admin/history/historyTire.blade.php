<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Master</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Master</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal" data-post="new"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Data</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
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
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Site</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Size</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Status</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg" alt="img"></a>
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
                            <th>Serial Number</th>
                            <th>Size</th>
                            <th>Pattern</th>
                            <th>Compound</th>
                            <th>Status</th>
                            <th>Lifetime</th>
                            <th>RTD</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>9928947382</td>
                            <td>29.00TR</td>
                            <td>Paten1</td>
                            <td>Compon1</td>
                            <td>status1</td>
                            <td>900</td>
                            <td>90</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning text-white">TIRE INSPECT</a>
                                <a href="#" class="btn btn-sm btn-primary text-white">TIRE MOVEMENT</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="form-modal" data-post="new" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Tire </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <label>Site</label>
                                    {{-- <select class="select" name="site_id" required>
                                        <option>Choose Site</option>
                                        @foreach ($site as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Size</label>
                                    {{-- <select class="select" name="tire_size_id" required>
                                        <option>Choose Size</option>
                                        @foreach ($tiresize as $item2)
                                            <option value="{{$item2->id}}">{{$item2->size}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Compound</label>
                                    {{-- <select class="select" name="tire_compound_id" required>
                                        <option>Choose Compound</option>
                                        @foreach ($tirecompound as $item3)
                                            <option value="{{$item3->id}}">{{$item3->compound}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    {{-- <select class="select" name="tire_status_id" required>
                                        <option>Choose Status</option>
                                        @foreach ($tirestatus as $item4)
                                            <option value="{{$item4->id}}">{{$item4->status}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tire Lifetime</label>
                                    <input type="text" name="lifetime" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" name="rtd" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Date </label>
                                    <div class="input-groupicon">
                                        <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker" name="date" required>
                                        <div class="addonset">
                                            <img src="assets/img/icons/calendars.svg" alt="img">
                                        </div>
                                    </div>
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
</x-app-layout>