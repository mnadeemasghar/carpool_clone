@extends('layouts.website')

@section('content')

<div class="container mt-4">

    <!-- Ride -->
    @if (isset($ride) && $ride->count() > 0)

        <div class="row g-4">
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
                        <p class="card-text">Pick-up Time: {{ \Carbon\Carbon::parse($ride->pick_time)->format('g:i A') }}</p>
                        <h5 class="card-subtitle mb-2 text-muted">Drop-off Location: {{ $ride->drop_location->title }}</h5>
                        <p class="card-text">Return Time: {{ \Carbon\Carbon::parse($ride->return_time)->format('g:i A') }}</p>

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
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Stop Form -->
                <form action="{{ route('stop.store', ['ride_id' => $ride->id]) }}" method="POST" class="d-flex align-items-start mb-3">
                    @csrf
                    <div class="form-group flex-grow-1 mr-2">
                        <input type="text" class="form-control" name="address" placeholder="Write your stop address..." />
                    </div>
                    @error('address')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </form>
                <!-- Display Stops Section -->
                @if ($ride->stops && $ride->stops->count() > 0)
                    <div class="mb-3">
                        <h5>Stops</h5>
                        @foreach ($ride->stops as $stop)
                            <div class="card mb-2">
                                <div class="card-body p-2">
                                    <div class="d-flex justify-content-between">
                                        <!-- <small class="text-muted">{{ $stop->created_at->format('d M Y, H:i') }}</small> -->
                                        <span class="font-weight-bold">{{ $stop->type }}</span>
                                    </div>
                                    <p class="mb-0">{{ $stop->address->title }}</p>
                                </div>
                                @if ($stop->type == \App\Models\Stop::TYPE_STOP)
                                <div class="card-footer">
                                    <form action="{{ route('stop.destroy',['ride_id'=>$ride->id,'stop'=>$stop->id]) }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No Stop yet</p>
                @endif
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
