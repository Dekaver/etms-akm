<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Size</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Size</li>
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
                                            <option>Choose Manufacture</option>
                                            <option>AELOUS</option>
                                            <option>ADVANCE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>GL665A</option>
                                            <option>GL690A</option>
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
                            <th>Size</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>OTD</th>
                            <th>Rec. Pressure</th>
                            <th>Target Lifetime</th>
                            <th>Price</th>
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
                            <td>AELOUS</td>
                            <td>27.00R</td>
                            <td>GL690A</td>
                            <td>LUG</td>
                            <td>92</td>
                            <td>80</td>
                            <td>12000</td>
                            <td>-</td>
                            <td>
                                <a class="me-3"  data-bs-toggle="modal" data-bs-target="#addmodal" href="editproduct.html">
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
                            <td>ADVANCE</td>
                            <td>21.02R</td>
                            <td>GL992A</td>
                            <td>MIX</td>
                            <td>91</td>
                            <td>90</td>
                            <td>11000</td>
                            <td>-</td>
                            <td>
                                <a class="me-3"  data-bs-toggle="modal" data-bs-target="#addmodal" href="editproduct.html">
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
                            <td>BRIDGESTONE</td>
                            <td>29.23R</td>
                            <td>GL665A</td>
                            <td>RIB</td>
                            <td>95</td>
                            <td>90</td>
                            <td>14000</td>
                            <td>-</td>
                            <td>
                                <a class="me-3"  data-bs-toggle="modal" data-bs-target="#addmodal" href="editproduct.html">
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
                    <h5 class="modal-title">Add Size </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-0">
                                <label>Tire Pattern</label>
                                <select class="select">
                                    <option>Choose Pattern</option>
                                    <option> ADVANCE</option>
                                    <option> AELOUS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>OTD</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Rec. Pressure</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Target Lifetime</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Price</label>
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