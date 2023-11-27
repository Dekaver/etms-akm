<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Target KM</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item" aria-current="page">Target KM</li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Target KM</h5>
                    <div class="row">
                        <div class="col-6">
                            <form action="" method="get">
                                <select name="tire_target_km_id"   class="form-control" onchange="this.parentElement.submit()">
                                    <option value="">Tire Target KM</option>
                                    @foreach ($list_tire_target_km as $item)
                                        <option value="{{ $item->id }}" @selected(Request::get("tire_target_km_id") == $item->id)>{{ $item->site->name }} | {{ $item->tire_size->size }} | {{ $item->tire_size->tire_pattern->manufacture->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <table class="table">
                                <tr>
                                    <td>Size</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->tire_size->size ?? "-" }}</td>
                                    <td>Jarak Hauling</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->site->jarak_hauling ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Site</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->site->name ?? "-" }}</td>
                                    <td>Rit/Hari</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->site->rit_per_hari ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Target KM/mili (RTD)</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->rtd_target_km ?? "-" }}</td>
                                    <td>Total Jarak</td>
                                    <td>:</td>
                                    <td>{{ $tiretargetkm->site->total_jarak ?? "-" }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col my-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Target KM</th>
                                <th>OTD</th>
                                <th>RTD</th>
                                <th>TUR</th>
                                <th>Remaining Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tiretargetkm)
                            @for ($rtd = (int) $tiretargetkm->tire_size->otd-1; $rtd >= 0; --$rtd)
                                <tr>
                                    <td>{{ (int) $tiretargetkm->tire_size->otd - $rtd }}</td>
                                    <td>{{ (int) $tiretargetkm->rtd_target_km * ((int) $tiretargetkm->tire_size->otd - $rtd) }}</td>
                                    <td>{{ (int) $tiretargetkm->tire_size->otd }}</td>
                                    <td>{{ $rtd }}</td>
                                    <td>{{ (int) $tiretargetkm->tire_size->otd - $rtd }}</td>
                                    <td>{{ round((int) $tiretargetkm->rtd_target_km * $rtd / (int) $tiretargetkm->site->total_jarak)  }}</td>
                                </tr>
                            @endfor
                            @else
                                <tr>
                                    <td colspan="5">Empty</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
