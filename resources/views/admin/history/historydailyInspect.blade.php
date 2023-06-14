<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Report</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Daily Inspect</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daily Monitoring</li>
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
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"
                                href="/report-daily-inspect-export?{{ explode('?', Request::getRequestUri())[1] ?? '' }}"><img
                                    src="assets/img/icons/excel.svg" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="site">
                                        <option value="">Choose Site</option>
                                        @foreach ($sites as $item)
                                            <option value="{{ $item->id }}" @selected($site == $item->id)>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="month">
                                        <option value="">Choose Month</option>
                                        <option value="1" @selected($month == '1')>Jan</option>
                                        <option value="2" @selected($month == '2')>Feb</option>
                                        <option value="3" @selected($month == '3')>Mar</option>
                                        <option value="4" @selected($month == '4')>Apr</option>
                                        <option value="5" @selected($month == '5')>Mei</option>
                                        <option value="6" @selected($month == '6')>Jun</option>
                                        <option value="7" @selected($month == '7')>Jul</option>
                                        <option value="8" @selected($month == '8')>Aug</option>
                                        <option value="9" @selected($month == '9')>Sep</option>
                                        <option value="10" @selected($month == '10')>Okt</option>
                                        <option value="11" @selected($month == '11')>Nov</option>
                                        <option value="12" @selected($month == '12')>Des</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="year">
                                        <option value="">Choose Years</option>
                                        @for ($i = 2022; $i < \Carbon\Carbon::now()->format('Y') + 1; $i++)
                                            <option value="{{ $i }}" @selected($year == $i)>
                                                {{ $i }}</option>
                                        @endfor
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
            <!-- /Filter -->
            <p>
                <span class="me-2">V: INSPECTION</span>
                <span class="me-2">R: REMOVE</span>
                <span class="me-2">I: INSTALL</span>
            </p>
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            @for ($i = 0; $i < $total_hari; $i++)
                                <th>{{ 1 + $i }}</th>
                            @endfor
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $item)
                            <tr>
                                <td>{{ $key }}</td>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($item as $v)
                                    @php
                                        if ($v != '-') {
                                            $total += 1;
                                        }
                                    @endphp
                                    <td>{{ $v }}</td>
                                @endforeach
                                <td>{{ $total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td align="center" colspan="{{ $total_hari + 2 }}">No Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
