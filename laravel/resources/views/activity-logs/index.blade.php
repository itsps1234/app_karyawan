@extends('layouts.dashboard')
@section('isi')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <!-- <center>
                <a href="{{ url('/dokumen/tambah') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah
                    Dokumen</a>
            </center> -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <h1>Activity Logs</h1>

            <form action="{{ route('activity-logs.index') }}" method="GET" class="form-inline mb-3">
                <div class="form-group mr-2">
                    <label for="activity" class="mr-2">Activity:</label>
                    <select name="activity" id="activity" class="form-control">
                        <option value="">All</option>
                        <option value="create" {{ request()->get('activity') === 'create' ? 'selected' : '' }}>Create
                        </option>
                        <option value="update" {{ request()->get('activity') === 'update' ? 'selected' : '' }}>Update
                        </option>
                        <option value="delete" {{ request()->get('activity') === 'delete' ? 'selected' : '' }}>Delete
                        </option>
                    </select>
                </div>

                <div class="form-group mr-2">
                    <label for="search" class="mr-2">Search:</label>
                    <input type="text" name="search" id="search" class="form-control"
                        value="{{ request()->get('search') }}">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Description</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                        <tr>
                            <td>{{ $logs->firstItem() + $loop->index }}</td>
                            <td>{{ $log->user->name }}</td>
                            <td>{{ ucfirst($log->activity) }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $logs->appends(request()->except('page'))->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<br>
@endsection