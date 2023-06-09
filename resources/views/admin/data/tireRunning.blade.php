<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Running Unit</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Running Unit</li>
                </ol>
            </nav>
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
                            <th>Unit</th>
                            <th>Type</th>
                            <th>SMU</th>
                            <th>Prime Mover</th>
                            <th>Last Update</th>
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
                            <td>DL7841</td>
                            <td>KM</td>
                            <td>213190 KM</td>
                            <td>PMSC003</td>
                            <td>2023-09-04</td>
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
    <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class=" modal-xl modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tire Inspection</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Unit number</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Prime Mover</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>SMU</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3"> 
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3"> 
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3"> 
                            <div class="form-group">
                                <label>Shift</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3"> 
                            <div class="form-group">
                                <label>Tyre Man</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-3"> 
                            <div class="form-group">
                                <label>Driver</label>
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive" style="overflow-x: scroll; white-space:nowrap">
                        <table class="table datascroll">
                            <thead>
                                <tr>
                                    <th>Pos</th>
                                    <th>Serial Number</th>
                                    <th>HM</th>
                                    <th>KM</th>
                                    <th>Pressure</th>
                                    <th>Dept Thread</th>
                                    <th>Tire</th>
                                    <th>Tube</th>
                                    <th>Flap</th>
                                    <th>Rim</th>
                                    <th>T.Pentil</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>023424989</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Baik</option>
                                                <option>Buruk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Baik</option>
                                                <option>Buruk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Baik</option>
                                                <option>Buruk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Baik</option>
                                                <option>Buruk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Baik</option>
                                                <option>Buruk</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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