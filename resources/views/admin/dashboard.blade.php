<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Dashboard {{ auth()->user()->company->name ?? '' }} - {{ auth()->user()->site->name ?? '' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">{{ auth()->user()->name }}</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count">
                <div class="dash-imgs">
                    <i data-feather="user"></i>
                </div>
                <div class="dash-counts">
                    <h4>100</h4>
                    <h5>New Stock</h5>
                </div>
            </div>
        </div>
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count das1">
                <div class="dash-imgs">
                    <i data-feather="user-check"></i>
                </div>
                <div class="dash-counts">
                    <h4>100</h4>
                    <h5>New Install</h5>
                </div>
            </div>
        </div>
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count das2">
                <div class="dash-imgs">
                    <i data-feather="file-text"></i>
                </div>
                <div class="dash-counts">
                    <h4>100</h4>
                    <h5>Tyre Spare</h5>
                </div>
            </div>
        </div>
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
                <div class="dash-counts">
                    <h4>105</h4>
                    <h5>Repairing</h5>
                </div>
            </div>
        </div>
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count das4">
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
                <div class="dash-counts">
                    <h4>105</h4>
                    <h5>Running</h5>
                </div>
            </div>
        </div>
        <div class="col-lg col-sm-6 col-12 d-flex">
            <div class="dash-count das3">
                <div class="dash-imgs">
                    <i data-feather="file"></i>
                </div>
                <div class="dash-counts">
                    <h4>105</h4>
                    <h5>Scrap</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h1>Tire Inventory</h1>
        </div>
        <div class="content">
            test
        </div>
    </div>
</x-app-layout>
