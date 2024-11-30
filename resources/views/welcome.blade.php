@extends('layouts.website')

@section('content')

<section class="card p-5 text-center border-0">
    <div class="card-body">
        <h1 class="display-4 fw-bold">{{ env('APP_TAGLINE') }}</h1>
        <p class="lead text-muted">Join our community to help reduce traffic, cut commuting costs, and enjoy a sustainable way to travel.</p>
        <p class="mt-4">
            <a class="btn btn-primary btn-lg me-3" href="{{ route('ride.create') }}">
                <i class="bi bi-plus-lg"></i> Create Ride
            </a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ route('ride.search') }}">
                <i class="bi bi-search"></i> Search Rides
            </a>
        </p>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <ul class="list-inline text-center">
                    <li class="list-inline-item m-2 badge bg-primary">
                        <i class="bi bi-car-front-fill"></i> {{ $rides }} Rides Created
                    </li>
                    <li class="list-inline-item m-2 badge bg-primary">
                        <i class="bi bi-person"></i> {{ $users }} Registered Users
                    </li>                    
                </ul>
            </div>
        </div>
    </div>
</section>


<div class="card text-center mb-5 border">
    <div class="card-body p-0">
    <iframe width="100%" height="450px" src="https://www.youtube.com/embed/WBlAxEWMguQ?si=jWHWhu-Wrv2_qnx_" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</div>

@if (isset($addresses) && $addresses->count() > 0)
<h4 class="text-center mb-4">Top 10 Popular Carpool Locations</h4>
<div class="d-flex flex-wrap justify-content-center mb-4">
    @foreach ($addresses as $address)
        <a href="{{ route('ride.search', ['pick_location_id' => $address->id]) }}" class="btn btn-warning m-2 shadow-sm">
            <i class="bi bi-geo-alt-fill me-2"></i> {{ $address->title }} ({{ $address->rides_count }} Rides)
        </a>
    @endforeach
</div>
@endif

<!-- Ride Request Call to Action -->
<div class="card text-center mb-5 border-0">
    <div class="card-body p-5">
        <h2 class="card-title">Can't Find Your Route?</h2>
        <p class="card-text">Set up your own ride request so others can find and join you.</p>
        <a href="{{ route('ride.create') }}" class="btn btn-primary btn-lg">Post Your Ride</a>
    </div>
</div>

<!-- How It Works Section -->
<div class="card mb-5 border-0">
    <div class="card-body p-5">
        <h2 class="card-title text-center mb-4">How Carpooling Works</h2>
        <div class="row text-start">
            <div class="col-md-4">
                <h4><i class="bi bi-person-plus-fill text-primary"></i> Sign Up</h4>
                <p>Create your profile and join a network of like-minded commuters.</p>
            </div>
            <div class="col-md-4">
                <h4><i class="bi bi-geo-alt text-primary"></i> Join a Carpool</h4>
                <p>Find groups that match your commute and travel route.</p>
            </div>
            <div class="col-md-4">
                <h4><i class="bi bi-cash-stack text-primary"></i> Share the Costs</h4>
                <p>Save on fuel expenses and reduce congestion while enjoying the ride.</p>
            </div>
        </div>
    </div>
</div>

<!-- Why CarpoolLahore Section -->
<div class="card mb-5 border-0">
    <div class="card-header bg-primary text-white p-4">
        <h3 class="card-title m-0">Welcome to CarpoolLahore – Your Community Carpool Solution!</h3>
    </div>
    <div class="card-body p-5">
        <p>CarpoolLahore.com is a user-focused platform dedicated to offering safe, reliable, and affordable carpooling. Join a community of commuters who share our mission to reduce traffic and commuting costs without hidden charges or fees.</p>

        <h4 class="mt-4">Why Choose CarpoolLahore?</h4>
        <ul class="list-unstyled">
            <li class="mb-3">
                <strong>No Hidden Fees</strong>: Zero commissions—what you pay goes directly to the driver.
            </li>
            <li class="mb-3">
                <strong>Transparent Cost-Sharing</strong>: Fair pricing without surprises.
            </li>
            <li class="mb-3">
                <strong>Community-First Approach</strong>: Designed for Lahore, by Lahore, making carpooling accessible to all.
            </li>
        </ul>

        <h4 class="mt-4">Future Sustainability</h4>
        <p>To cover basic expenses, we may introduce a small subscription fee in the future. However, our commitment to affordability and transparency remains unchanged.</p>

        <p class="mt-4 text-center">
            <strong>Be Part of the Movement!</strong><br>
            <em>Help us make commuting across Lahore easier, more affordable, and greener.</em>
        </p>
    </div>
</div>

@endsection
