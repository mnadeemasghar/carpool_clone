<!-- Sidebar Filter -->
<div class="bg-light border rounded-3 p-3 mb-3 shadow-sm">
    <h5 class="text-primary fw-bold mb-3"><i class="bi bi-funnel"></i> Filter Results</h5>

    <form method="GET" action="{{ route('ride.search') }}" class="row g-2 align-items-end d-flex justify-content-center">
        <!-- Pick-up Location Selection -->
        <div class="col-auto">
            <label for="pick_location_id" class="form-label fw-semibold mb-0 small">My Location</label>
            <select id="pick_location_id" name="pick_location_id" class="form-select form-select-sm">
                <option value="" {{ old('pick_location_id', request()->input('pick_location_id')) == '' ? 'selected' : '' }}>Any</option>
                @foreach ($pickAddresses as $pickAddress)
                    <option value="{{ $pickAddress->id }}" {{ old('pick_location_id', request()->input('pick_location_id')) == $pickAddress->id ? 'selected' : '' }}>
                        {{ $pickAddress->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Looking For Role Selection -->
        <div class="col-auto">
            <label for="role" class="form-label fw-semibold mb-0 small">Looking For</label>
            <select id="role" name="role" class="form-select form-select-sm">
                <option value="" {{ old('role', request()->input('role')) == '' ? 'selected' : '' }}>Any</option>
                <option value="{{ \App\Models\Ride::ROLE_PASSENGER }}" {{ old('role', request()->input('role')) == \App\Models\Ride::ROLE_PASSENGER ? 'selected' : '' }}>
                    Passenger
                </option>
                <option value="{{ \App\Models\Ride::ROLE_DRIVER }}" {{ old('role', request()->input('role')) == \App\Models\Ride::ROLE_DRIVER ? 'selected' : '' }}>
                    Driver
                </option>
            </select>
        </div>

        <!-- Vehicle Type Selection -->
        <div class="col-auto">
            <label for="vehicle_type" class="form-label fw-semibold mb-0 small">Vehicle Type</label>
            <select id="vehicle_type" name="vehicle_type" class="form-select form-select-sm">
                <option value="" {{ old('vehicle_type', request()->input('vehicle_type')) == '' ? 'selected' : '' }}>Any</option>
                <option value="{{ \App\Models\Ride::VEHICLE_CAR }}" {{ old('vehicle_type', request()->input('vehicle_type')) == \App\Models\Ride::VEHICLE_CAR ? 'selected' : '' }}>
                    Car
                </option>
                <option value="{{ \App\Models\Ride::VEHICLE_BIKE }}" {{ old('vehicle_type', request()->input('vehicle_type')) == \App\Models\Ride::VEHICLE_BIKE ? 'selected' : '' }}>
                    Bike
                </option>
                <option value="{{ \App\Models\Ride::VEHICLE_VAN }}" {{ old('vehicle_type', request()->input('vehicle_type')) == \App\Models\Ride::VEHICLE_VAN ? 'selected' : '' }}>
                    Van
                </option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-auto">
            <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i> Search</button>
        </div>

        <!-- Reset Button -->
        <div class="col-auto">
            <a href="{{ request()->url() }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Reset</a>
        </div>
    </form>
</div>
