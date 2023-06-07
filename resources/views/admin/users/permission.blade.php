<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Permission Users</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Permission</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>{{ $user->name }}</h4>
            <h6>{{ $user->email }}</h6>
            <hr>
            <form action="{{ route('user.permission.update', $user->id) }}" method="POST">
                @csrf
                <h5>Role</h5>
                <div class="form-group row">
                    <div class="col-md-12">
                        <select name="role" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}" @selected($user->hasRole($item->name))>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <h5>Site</h5>
                <div class="form-group row">
                    <div class="col-md-12">
                        <select name="site_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach ($sites as $item)
                                <option value="{{ $item->id }}" @selected(($user->site->id ?? null) == $item->id)>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <h5>Permission</h5>
                <div class="form-group row">
                    <div class="col-md-12">
                        @foreach ($permissions as $item)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permission[]" value="{{ $item->name }}"
                                        @checked($user->hasPermissionTo($item->name))>
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit">Simpan</button>
            </form>



        </div>
    </div>
</x-app-layout>
