@extends('layouts.website')

@section('content')
    <h1 class="my-4">User Profile</h1>

    <!-- User Profile Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="{{ $user->profile_photo_url }}" alt="User Profile" class="rounded-circle me-3" width="100" height="100">
                <div>
                    <h5 class="mb-0">{{$user->name}}</h5>
                    <small class="text-muted">Gender: {{$user->gender ?? "-"}}</small>
                    |<small class="text-muted">Email: {{$user->email}}</small>
                    |<small class="text-muted">Phone: {{$user->phone}}</small>
                    <div class="text-warning mt-2">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <small class="text-muted">(0/5 based on 0 reviews)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Rides with Reviews Section -->
    <h4 class="my-4">Recent Rides & Reviews</h4>

    <div class="row mb-4">
    @if (isset($user->completedRides) && $user->completedRides->count() > 0)
        <!-- Ride Card 1 -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-success">Ride from Location A to Location B</h5>
                    <p class="mb-1"><span class="badge bg-info text-dark">Passenger</span> | Vehicle: Car</p>
                    <small class="text-muted">Date: 10 Nov, 2024 | Price: PKR 1500</small>
                    
                    <h6 class="mt-4 text-muted">Reviews:</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 ps-0">
                            <strong>User 1:</strong>
                            <p class="mb-1">Great ride experience! Highly recommend.</p>
                            <small class="text-muted">Reviewed on: 05 Nov, 2024</small>
                        </div>
                        <div class="list-group-item border-0 ps-0">
                            <strong>User 2:</strong>
                            <p class="mb-1">Very friendly and punctual. Will ride again!</p>
                            <small class="text-muted">Reviewed on: 02 Nov, 2024</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    @else
    <p>Reviews are comming soon</p>
    @endif
    </div>

@endsection
