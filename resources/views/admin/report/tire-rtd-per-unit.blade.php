<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Report</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Report Tire Running</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Tire Tire Running</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter {{ $unitmodel_id || $unitsite_id || $unitstatus_id ? ' setclose' : '' }}"
                            id="filter_search">
                            <img src="assets/img/icons/filter.svg" alt="img">
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                    </div>
                </div>
            </div>
            <!-- /Filter -->

            <div class="card mb-0" id="filter_inputs"
                {{ $unitmodel_id || $unitsite_id || $unitstatus_id ? 'style=display:block' : '' }}>
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="unitmodel">
                                                <option value="">Choose Unit Model</option>
                                                @foreach ($unit_model as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $unitmodel_id)>
                                                        {{ $item->model }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="unitsite">
                                                <option value="">Choose Site</option>
                                                @foreach ($sites as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $unitsite_id)>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="unitstatus">
                                                <option value="">Choose Status</option>
                                                @foreach ($unit_status as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $unitstatus_id)>
                                                        {{ $item->status_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-filters ms-auto"><img
                                                    src="assets/img/icons/search-whites.svg" alt="img"></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Table -->
            <div class="row">
                @forelse ($units as $unit)
                    <x-unit :unit="$unit"/>
                @empty
                    NULL
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
