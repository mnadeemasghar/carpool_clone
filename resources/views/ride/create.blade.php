@extends('layouts.website')

@section('content')
<div class="card shadow mb-5">
    <div class="card-header bg-primary text-white">Create Your Ride Request</div>
    <div class="card-body px-5">

        <form action="{{ route('ride.store') }}" method="POST">
            @csrf

            <!-- User Info (for guests only) -->
            @if (Auth::guest())
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold required">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control shadow-sm" value="{{ old('name') }}" placeholder="Enter your name">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="gender" class="form-label fw-bold required">Gender</label>
                        <select name="gender" id="gender" class="form-control shadow-sm">
                            <option value="">Select Gender</option>
                            <option value="{{ \App\Models\User::GENDER_MALE }}" {{ old('gender') == \App\Models\User::GENDER_MALE ? 'selected' : '' }}>Male</option>
                            <option value="{{ \App\Models\User::GENDER_FEMALE }}" {{ old('gender') == \App\Models\User::GENDER_FEMALE ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold required">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control shadow-sm" value="{{ old('email') }}" placeholder="Enter your email">
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-bold">Contact Number</label>
                        <input type="text" name="phone" id="phone" class="form-control shadow-sm" value="{{ old('phone') }}" placeholder="Optional">
                        @error('phone')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-bold required">Create Password</label>
                        <input type="password" name="password" id="password" class="form-control shadow-sm" placeholder="Password">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Ride Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="role" class="form-label fw-bold required">Your Role</label>
                    <select name="role" id="role" class="form-control shadow-sm">
                        <option value="" disabled selected>--- Select Role ---</option>
                        <option value="Driver" {{ old('role') == 'Driver' ? 'selected' : '' }}>Driver</option>
                        <option value="Passenger" {{ old('role') == 'Passenger' ? 'selected' : '' }}>Passenger</option>
                    </select>
                    @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vehicle_type" class="form-label fw-bold required">Vehicle Type</label>
                    <select name="vehicle_type" id="vehicle_type" class="form-control shadow-sm">
                        <option value="" disabled selected>--- Select Vehicle Type ---</option>
                        <option value="Car" {{ old('vehicle_type') == 'Car' ? 'selected' : '' }}>Car</option>
                        <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="Bike" {{ old('vehicle_type') == 'Bike' ? 'selected' : '' }}>Bike</option>
                    </select>
                    @error('vehicle_type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="trip_type" class="form-label fw-bold required">Trip Type</label>
                    <select name="trip_type" id="trip_type" class="form-control shadow-sm">
                        <option value="" disabled selected>--- Select Trip Type ---</option>
                        <option value="One Way" {{ old('trip_type') == 'One Way' ? 'selected' : '' }}>One Way</option>
                        <option value="Round Trip" {{ old('trip_type') == 'Round Trip' ? 'selected' : '' }}>Round Trip</option>
                    </select>
                    @error('trip_type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="offer" class="form-label fw-bold required">Offer Price per day (PKR)</label>
                    <input type="number" name="offer" id="offer" class="form-control shadow-sm" placeholder="Enter offer price" value="{{ old('offer') }}">
                    @error('offer')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="pick_location" class="form-label fw-bold required">Pick-Up Location</label>
                    <input type="text" name="pick_location" id="pick_location" onkeyup="getLocationSuggestions('pick_location','pick_suggest','{{route('api.getAddress')}}')" class="form-control shadow-sm" placeholder="Enter pick-up location" value="{{ old('pick_location') }}">
                    @error('pick_location')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <div id="pick_suggest" class="mt-2 position-relative"></div>
                </div>

                <div class="col-md-6">
                    <label for="drop_location" class="form-label fw-bold required">Drop-Off Location</label>
                    <input type="text" name="drop_location" id="drop_location" onkeyup="getLocationSuggestions('drop_location','drop_suggest','{{route('api.getAddress')}}')" class="form-control shadow-sm" placeholder="Enter drop-off location" value="{{ old('drop_location') }}">
                    @error('drop_location')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <div id="drop_suggest" class="mt-2 position-relative"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="pick_time" class="form-label fw-bold required">Pick-Up Time</label>
                    <input type="time" name="pick_time" id="pick_time" class="form-control shadow-sm" value="{{ old('pick_time') }}">
                    @error('pick_time')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="return_time" class="form-label fw-bold">Return Time</label>
                    <input type="time" name="return_time" id="return_time" class="form-control shadow-sm" value="{{ old('return_time') }}">
                    @error('return_time')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="start_date" class="form-label fw-bold required">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control shadow-sm" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label fw-bold required">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control shadow-sm" value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold required">Select Days Available</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach (['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'] as $day => $dayName)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="{{ $day }}" name="{{ $day }}" {{ old($day) == 'on' ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $day }}">{{ $dayName }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-4">
                    <label for="terms">
                        <div class="flex items-center">
                            <input type="checkbox" class="form-check-input" name="terms" id="terms" />

                            <div class="">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                            @error('terms')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </label>
                </div>
            @endif

            <div class="text-center">
                <button type="submit" class="btn btn-primary shadow-sm">Submit Ride Request</button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/addresses.js') }}"></script>
@endsection
