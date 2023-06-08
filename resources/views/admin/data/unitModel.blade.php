<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Unit Model</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Unit Model</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addmodal"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Data</a>
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
                <table class="table  datanew">
                    <thead>
                        <tr>
                            <th width="5%">
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Brand</th>
                            <th>Unit Model</th>
                            <th>Model Type</th>
                            <th>Tire Size</th>
                            <th>Tire Quantity</th>
                            <th>Axle 2 Tire</th>
                            <th>Axle 4 Tire</th>
                            <th>Axle 8 Tire</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Unit Model </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>Unit Model</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label>Model Type</label>
                                <select class="select">
                                    <option>Choose Model</option>
                                    <option> Prime Mover</option>
                                    <option> Trailer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label>Tire Size</label>
                                <select class="select">
                                    <option value="">Choose Size</option>
                                    @foreach ($tiresize as $item)
                                    <option value="{{ $item->id }}">Choose Size</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Tire Qty</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Axle 2 Tire</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Axle 4 Tire</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Axle 8 Tire</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Load Distribution</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>Empty Weight Info</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Standar Load Capacity</label>
                                <input type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-submit">Save</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
