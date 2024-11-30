@extends('layouts.website')

@section('title', $ride->pick_location->title . ' to ' . $ride->drop_location->title . ' | Carpool Lahore')

@section('meta')
    <meta name="description" content="Join this ride from {{ $ride->pick_location->title }} to {{ $ride->drop_location->title }} on {{ $ride->start_date }}. {{ $ride->vehicle_type }} driven by {{ $ride->user->name }}. Share your trip with CarpoolLahore.com.">
    <meta name="keywords" content="Carpool Lahore, rideshare, carpooling, {{ $ride->pick_location->title }}, {{ $ride->drop_location->title }}, {{ $ride->vehicle_type }}, {{ $ride->trip_type }}">
    <meta property="og:title" content="{{ $ride->pick_location->title }} to {{ $ride->drop_location->title }} | Carpool Lahore">
    <meta property="og:description" content="Plan your journey with this ride from {{ $ride->pick_location->title }} to {{ $ride->drop_location->title }}. Available on {{ $ride->start_date }} with {{ $ride->user->name }}.">
    <meta property="og:url" content="{{ route('ride.show', ['ride' => $ride]) }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ride->user->profile_photo_url }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ride->pick_location->title }} to {{ $ride->drop_location->title }} | Carpool Lahore">
    <meta name="twitter:description" content="Join this ride with {{ $ride->user->name }}. {{ $ride->vehicle_type }} available on {{ $ride->start_date }}.">
@endsection

@section('content')

<div class="row">
    <div class="col-md-9 mb-4">
        <x-ride-card :ride="$ride" />
    </div>

    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Interested Users</h5>
            </div>
            <div class="card-body">
                @if ($ride->interested_users->count() > 0)
                    @foreach ($ride->interested_users as $user)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <div class="text-muted">{{ $user->phone }}</div>
                            </div>
                            <div>
                                <a href="{{route('user.show',['user'=>$user])}}" class="btn btn-sm btn-outline-secondary">Profile</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-muted">
                        <span>No user showed interest in the ride; we are also waiting with you.</span>
                    </div>
                @endif
            </div>
        </div>

        @auth
            <div class="mt-4">
                <livewire:ride-comments :ride="$ride" />
            </div>
        @else
            <div class="alert alert-info mt-4">
                <p>Please <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to comment here.</p>
            </div>
        @endauth
    </div>
</div>

@endsection
