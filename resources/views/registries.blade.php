@extends('adminLayout')

@section('title', 'Dashboard')

@section('content')
    <!-- Registries Content -->
    <div id="registries" class="table-container content-section">
        <h2>Registries Table</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Type</th>
                        <th>Vehicles</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($requests->isNotEmpty())
                        @foreach($requests as $request)
                            <tr>
                                <td>{{ $request->user->full_name }}</td>
                                <td>{{ $request->user->type }}</td>
                                <td>{{ $request->type }}</td>
                                <td>{{ is_array(json_decode($request->vehicle_ids, true)) ? count(json_decode($request->vehicle_ids, true)) : '0' }}</td>
                                <td>{{ ucfirst($request->status) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">No registration requests found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
