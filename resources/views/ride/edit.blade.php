@extends('layouts.website')

@section('content')
<div class="card shadow mb-5">
    <div class="card-header">Edit Ride Request</div>
    <div class="card-body">

        <form action="{{ route('ride.update', ['ride' => $ride]) }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="role" class="form-label required">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="" {{ (old('role') ?? $ride->role) == '' ? 'selected' : '' }}>--- Select One ---</option>
                        <option value="Driver" {{ (old('role') ?? $ride->role) == 'Driver' ? 'selected' : '' }}>Driver</option>
                        <option value="Passenger" {{ (old('role') ?? $ride->role) == 'Passenger' ? 'selected' : '' }}>Passenger</option>
                    </select>

                    @error('role')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="vehicle_type" class="form-label required">Vehicle Type</label>
                    <select name="vehicle_type" id="vehicle_type" class="form-control">
                        <option value="" {{ (old('vehicle_type') ?? $ride->vehicle_type) == '' ? 'selected' : '' }}>--- Select One ---</option>
                        <option value="Car" {{ (old('vehicle_type') ?? $ride->vehicle_type) == 'Car' ? 'selected' : '' }}>Car</option>
                        <option value="Van" {{ (old('vehicle_type') ?? $ride->vehicle_type) == 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="Bike" {{ (old('vehicle_type') ?? $ride->vehicle_type) == 'Bike' ? 'selected' : '' }}>Bike</option>
                    </select>

                    @error('vehicle_type')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="trip_type" class="form-label required">Trip Type</label>
                    <select name="trip_type" id="trip_type" class="form-control">
                        <option value="" {{ (old('trip_type') ?? $ride->trip_type) == '' ? 'selected' : '' }}>--- Select One ---</option>
                        <option value="One Way" {{ (old('trip_type') ?? $ride->trip_type) == 'One Way' ? 'selected' : '' }}>One Way</option>
                        <option value="Round Trip" {{ (old('trip_type') ?? $ride->trip_type) == 'Round Trip' ? 'selected' : '' }}>Round Trip</option>
                    </select>

                    @error('trip_type')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="offer" class="form-label required">Offer Price per Day</label>
                    <input type="number" name="offer" id="offer" class="form-control" value="{{ old('offer', $ride->offer ?? '') }}" min="0" step="0.01">

                    @error('offer')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="note" class="form-label">Extra Note</label>
                    <input type="text" name="note" id="note" class="form-control" value="{{ old('note', $ride->note ?? '') }}">

                    @error('note')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="pick_location" class="form-label required">Pick Location</label>
                    <input type="text" name="pick_location" id="pick_location" class="form-control" value="{{ old('pick_location', $ride->pick_location ?? '') }}">

                    @error('pick_location')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="pick_time" class="form-label required">Pick Time</label>
                    <input type="time" name="pick_time" id="pick_time" class="form-control" value="{{ old('pick_time', $ride->pick_time ?? '') }}">

                    @error('pick_time')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="drop_location" class="form-label required">Drop Location</label>
                    <input type="text" name="drop_location" id="drop_location" class="form-control" value="{{ old('drop_location', $ride->drop_location ?? '') }}">

                    @error('drop_location')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="return_time" class="form-label">Return Time</label>
                    <input type="time" name="return_time" id="return_time" class="form-control" value="{{ old('return_time', $ride->return_time ?? '') }}">

                    @error('return_time')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label required">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $ride->start_date ?? '') }}">

                    @error('start_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="end_date" class="form-label required">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $ride->end_date ?? '') }}">

                    @error('end_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Days of the Week Checkboxes -->
            <div class="mb-3">
                <label class="form-label required">Days of the Week</label>
                @error('days')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                <div class="flex flex-wrap">
                    @foreach (['mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday', 'sun' => 'Sunday'] as $day => $dayName)
                        <div class="form-check ml-6 mb-2 sm:mb-0 sm:mr-6">
                            <input class="form-check-input" type="checkbox" name="{{ $day }}" id="{{ $day }}" {{ old($day) == 'on' ? 'checked' : ($ride->$day == 'on' ? 'checked' : '') }}>
                            <label class="form-check-label" for="{{ $day }}">
                                {{ __($dayName) }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="cta-button">{{ isset($ride) ? 'Update Ride' : 'Submit Ride' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
