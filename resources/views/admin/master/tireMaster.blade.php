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
                <table class="table  datanew">
                    <thead>
                        <tr>
                            <th width="5%">
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Site</th>
                            <th>Serial Number</th>
                            <th>Size</th>
                            <th>Pattern</th>
                            <th>Status</th>
                            <th>Lifetime</th>
                            <th>RTD</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>SENYIUR</td>
                            <td>0N0289394JA</td>
                            <td>12.099R</td>
                            <td>GL690A</td>
                            <td>Running</td>
                            <td>12000</td>
                            <td>5</td>
                            <td>19 Juni 2023</td>
                            <td>
                                <a class="me-3" data-bs-toggle="modal" data-bs-target="#addmodal" href="editproduct.html">
                                    <img src="assets/img/icons/edit.svg" alt="img">
                                </a>
                                <a class="confirm-text" href="javascript:void(0);">
                                    <img src="assets/img/icons/delete.svg" alt="img">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>KARIANGAU</td>
                            <td>0J2048931</td>
                            <td>22.02R</td>
                            <td>GL660A</td>
                            <td>Running</td>
                            <td>16000</td>
                            <td>10</td>
                            <td>20 Juni 2023</td>
                            <td>
                                <a class="me-3" data-bs-toggle="modal" data-bs-target="#addmodal" href="editproduct.html">
                                    <img src="assets/img/icons/edit.svg" alt="img">
                                </a>
                                <a class="confirm-text" href="javascript:void(0);">
                                    <img src="assets/img/icons/delete.svg" alt="img">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <select class="select">
                                    <option>Choose Site</option>
                                    <option> 1</option>
                                    <option> 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Serial Number</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Size</label>
                                <select class="select">
                                    <option>Choose Size</option>
                                    <option> 1</option>
                                    <option> 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Compound</label>
                                <select class="select">
                                    <option>Choose Compound</option>
                                    <option> 1</option>
                                    <option> 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="select">
                                    <option>Choose Status</option>
                                    <option> 1</option>
                                    <option> 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tire Lifetime</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>RTD</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Quotation Date </label>
                                <div class="input-groupicon">
                                    <input type="text" placeholder="DD-MM-YYYY" class="datetimepicker">
                                    <div class="addonset">
                                        <img src="assets/img/icons/calendars.svg" alt="img">
                                    </div>
                                </div>
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