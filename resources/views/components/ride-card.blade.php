<div class="card shadow-sm mb-3 border-0">
    <div class="card-body">
        <!-- User Profile Section -->
        <a href="{{route('user.show',['user' => $ride->user])}}" class="text-decoration-none">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ $ride->user->profile_photo_url }}" alt="User Profile" class="rounded-circle me-3" width="50" height="50">
                <div>
                    <h6 class="mb-0">{{ $ride->user->name }}</h6>
                    <!-- <small class="text-muted">0 Rides Completed</small>
                    <div class="text-warning">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <small class="text-muted">(0)</small>
                    </div> -->
                </div>
            </div>
        </a>

        <!-- Ride Information Section -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title text-primary mb-0">
                {{ $ride->pick_location->title }}
                <i class="bi bi-arrow-right text-muted mx-1"></i>
                {{ $ride->drop_location->title }}
            </h5>
            <span class="text-muted small">
                <i class="bi bi-calendar-week me-1"></i> Available: 
                {{
                    ($ride->sun == "on" ? "Sun, " : "") .
                    ($ride->mon == "on" ? "Mon, " : "") .
                    ($ride->tue == "on" ? "Tue, " : "") .
                    ($ride->wed == "on" ? "Wed, " : "") .
                    ($ride->thu == "on" ? "Thu, " : "") .
                    ($ride->fri == "on" ? "Fri, " : "") .
                    ($ride->sat == "on" ? "Sat" : "")
                }}
            </span>
        </div>

        @if (isset($ride->stops) && $ride->stops->count() > 0)
        <!-- Stops Section -->
        <div class="mb-3">
            <h6 class="text-muted">Stops:</h6>
            <ul class="list-unstyled">
                @foreach ($ride->stops as $key => $stop)
                <li><i class="bi bi-geo-alt-fill"></i> Stop {{$key + 1}}: {{$stop->address->title}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Time, Role, and Vehicle Details -->
        <div class="d-flex flex-wrap">
            <div class="d-flex align-items-center me-3 mb-2">
                <i class="bi bi-clock text-secondary me-2"></i>
                <span class="text-muted small">{{ date('h:i A', strtotime($ride->pick_time)) }}</span>
                <span class="text-muted small"><i class="bi bi-dash"></i></span>
                <span class="text-muted small">{{ date('h:i A', strtotime($ride->return_time)) }}</span>
            </div>
            <div class="d-flex align-items-center me-3 mb-2">
                <i class="bi bi-arrow-down-up text-secondary me-2"></i>
                <span class="text-muted small">Trip: <strong>{{ $ride->trip_type }}</strong></span>
            </div>
            <div class="d-flex align-items-center me-3 mb-2">
                <i class="bi bi-person-fill text-secondary me-2"></i>
                <span class="text-muted small">Role: <strong>{{$ride->role}}</strong></span>
            </div>
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-car-front-fill text-secondary me-2"></i>
                <span class="text-muted small">Vehicle: <strong>{{$ride->vehicle_type}}</strong></span>
            </div>
        </div>

        <!-- Price Section -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="badge bg-success px-3 py-2">PKR {{$ride->offer}} / person / trip</span>
            <!-- Interest Section -->
            <div>
                @if ($ride->isUserInterested(auth()->id()))
                    <form action="{{ route('ride.interested', ['ride' => $ride]) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">Undo Interest</button>
                    </form>
                @else
                    <form action="{{ route('ride.interested', ['ride' => $ride]) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Show Interest</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
