@if (isset($rides) && $rides->count() > 0)

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row gy-3">
            @foreach ($rides as $ride)
                @php
                $rideStatus = $ride->end_date >= today() ? "Active" : "Expired";
                $statusClass = $rideStatus == 'Active' ? 'bg-success' : 'bg-danger';
                @endphp

                <!-- Ride Card -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card {{ $rideStatus == 'Active' ? 'border-success' : 'border-warning' }} h-100">
                        <div class="card-body">
                            <!-- Ride Info -->
                            <h6 class="card-title">{{ $ride->note }}</h6>
                            <p><strong>Route:</strong> {{ $ride->pick_location->title }} 
                                <i class="bi bi-arrow-right text-muted"></i> 
                                {{ $ride->drop_location->title }}
                            </p>
                            <p><strong>Time:</strong> 
                                <span class="text-muted">{{ date('h:i A', strtotime($ride->pick_time)) }}</span> 
                                <i class="bi bi-dash"></i> 
                                <span class="text-muted">{{ date('h:i A', strtotime($ride->return_time)) }}</span>
                            </p>
                            <p><strong>Date:</strong> 
                                <span class="text-muted">{{ \Carbon\Carbon::parse($ride->start_date)->format('d M Y') }}</span> 
                                <i class="bi bi-dash"></i> 
                                <span class="text-muted">{{ \Carbon\Carbon::parse($ride->end_date)->format('d M Y') }}</span>
                            </p>
                            
                            <!-- Stats -->
                            <div class="d-flex flex-wrap align-items-center mb-2">
                                <span class="badge bg-info me-2">{{ $ride->comments->count() }} Comments</span>
                                <span class="badge bg-primary">{{ $ride->interested_users->count() }} Interested</span>
                            </div>
                            
                            <!-- Status -->
                            <span class="badge {{ $statusClass }}">
                                <i class="bi {{ $rideStatus == 'Active' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill' }}"></i> 
                                {{ $rideStatus }}
                            </span>
                        </div>

                        <!-- Edit and Delete Buttons -->
                        <div class="card-footer bg-transparent d-flex justify-content-between">
                            <a href="{{ route('ride.edit', $ride->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('ride.destroy', $ride->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ride?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $rides->firstItem() }} to {{ $rides->lastItem() }} of {{ $rides->total() }} rides
            </div>
            <div>
                {{ $rides->links() }}
            </div>
        </div>
    </div>
</div>

@else
<div class="alert alert-info text-center mt-4" role="alert">
    <i class="bi bi-info-circle-fill me-2"></i> 
    No rides are available right now. Check back later or set up a new ride.
</div>
@endif
