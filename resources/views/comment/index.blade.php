@extends('layouts.website')

@section('content')

<div class="container mt-4">

    <!-- Ride -->
    @if (isset($ride) && $ride->count() > 0)

        <div class="row g-4">
            <div class="col-md-4">
                <x-ride-card :ride="$ride" />
            </div>

            <div class="col-md-6">
                <x-ride-comments :ride="$ride" />
            </div>

        </div>

    @else
    <div class="card text-center">
        <div class="card-body">
            <h2 class="card-title">Invalid Ride or the Ride You're Looking for is No Longer Available</h2>
            <p class="card-text">Submit your own ride request to help others find and contact you.</p>
            <a href="{{ route('ride.create') }}" class="btn btn-primary">Post a Request</a>
        </div>
    </div>

    @endif
</div>

@endsection
