@extends('layouts.website')

@section('content')

<div class="container mt-4">

    <!-- Search Form -->
    <div class="mb-4">
        <form method="GET" action="{{ route('ride.search') }}" class="row g-3">
            <div class="col-md-6">
                <label for="pick_location_id" class="form-label">Pick-up Location</label>
                <select id="pick_location_id" name="pick_location_id" required class="form-select">
                    @foreach ($pickAddresses as $pickAddress)
                        <option value="{{ $pickAddress->id }}" {{ $pick_location_id == $pickAddress->id ? 'selected' : '' }}>
                            {{ $pickAddress->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="drop_location_id" class="form-label">Drop-off Location</label>
                <select id="drop_location_id" name="drop_location_id" required class="form-select">
                    @foreach ($dropAddresses as $dropAddress)
                        <option value="{{ $dropAddress->id }}" {{ $drop_location_id == $dropAddress->id ? 'selected' : '' }}>
                            {{ $dropAddress->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <input type="submit" value="Find" class="btn btn-primary w-100" />
            </div>
        </form>
    </div>

    <!-- Rides List -->
    @if (isset($rides) && $rides->count() > 0)
        <div class="mb-4">
            {{ $rides->appends($_GET)->links() }}
        </div>

        <div class="row g-4">
            @foreach ($rides as $ride)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">PKR {{ $ride->offer }} - {{ $ride->trip_type }}</h3>

                            <p>{{ $ride->start_date }} - {{ $ride->end_date }} ({{ \Carbon\Carbon::parse($ride->start_date)->diffInDays(\Carbon\Carbon::parse($ride->end_date)) }} days)</p>

                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ $ride->user->profile_photo_url }}" alt="{{ $ride->user->name }}'s Profile Photo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="ms-3">
                                    <h4 class="card-subtitle mb-0 text-muted">{{ $ride->user->name }}</h4>
                                    <p class="card-text mb-0">{{ $ride->gender }} - {{ $ride->vehicle_type }} {{ $ride->role }}</p>
                                </div>
                            </div>
                            <p class="card-text">{{ $ride->note }}</p>
                            <p class="card-text">
                                @if ($ride->mon == 'on') Monday @endif
                                @if ($ride->tue == 'on') Tuesday @endif
                                @if ($ride->wed == 'on') Wednesday @endif
                                @if ($ride->thu == 'on') Thursday @endif
                                @if ($ride->fri == 'on') Friday @endif
                                @if ($ride->sat == 'on') Saturday @endif
                                @if ($ride->sun == 'on') Sunday @endif
                            </p>
                            <h5 class="card-subtitle mb-2 text-muted">Pick-up Location: {{ $ride->pick_location->title }}</h5>
                            <p class="card-text">Pick-up Time: {{ $ride->pick_time }}</p>
                            <h5 class="card-subtitle mb-2 text-muted">Drop-off Location: {{ $ride->drop_location->title }}</h5>
                            <p class="card-text">Return Time: {{ $ride->return_time }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-around">
                            @if ($ride->user->phone != "")
                                <a aria-label="Chat on WhatsApp" href="https://wa.me/{{env('COUNTRY_CODE')}}{{ $ride->user->phone }}" target="_blank" class="text-success">
                                    <i class="bi bi-whatsapp" style="font-size: 1.5rem;"></i>
                                </a>
                                <a aria-label="Call" href="tel://{{env('COUNTRY_CODE')}}{{ $ride->user->phone }}" target="_blank" class="text-primary">
                                    <i class="bi bi-telephone" style="font-size: 1.5rem;"></i>
                                </a>
                            @endif
                            <a aria-label="Comment" href="{{route('comment.index',['ride_id' => $ride->id])}}" class="text-primary">
                                <i class="bi bi-chat" style="font-size: 1.5rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $rides->appends($_GET)->links() }}
        </div>
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">Can't Find a Suitable Ride?</h2>
                <p class="card-text">Submit your own ride request to help others find and contact you.</p>
                <a href="{{ route('ride.create') }}" class="btn btn-primary">Post a Request</a>
            </div>
        </div>

    @else
        <div class="card text-center">
            <div class="card-body">
                <h2 class="card-title">No Rides Available</h2>
                <p class="card-text">Create your own ride request so that others can view and contact you.</p>
                <a href="{{ route('ride.create') }}" class="btn btn-primary">Create Now</a>
            </div>
        </div>
    @endif
</div>

@endsection
