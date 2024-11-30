@extends('layouts.website')

@section('content')

<div class="container-fluid">
    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-md-12">
            <x-ride-search-form :pickAddresses="$pickAddresses" :selectedAddressId="$pick_location_id" />
        </div>
    </div>

    <!-- Map and Rides Section -->
    <div class="row">
        <!-- Map Section -->
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="map-container border rounded-3 shadow-sm">
                <x-map />
            </div>
        </div>

        <!-- Rides List Section -->
        <div class="col-lg-6 col-md-12">
            @if (isset($rides) && $rides->count() > 0)
                <div class="mb-4">
                    {{ $rides->appends(request()->query())->links() }}
                </div>

                <div class="row g-4">
                    @foreach ($rides as $ride)
                        <div class="col-md-12">
                            <x-ride-card-list-item :ride="$ride" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $rides->appends(request()->query())->links() }}
                </div>
            @else
                <div class="card col-md-12 text-center">
                    <div class="card-body">
                        <h2 class="card-title">No Rides Available</h2>
                        <p class="card-text">Create your own ride request so that others can view and contact you.</p>
                        <a href="{{ route('ride.create') }}" class="btn btn-primary">Create Now</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Convert rides from Blade to a JavaScript variable
    const rides = @json($mapedRides);

    // Function to generate a random color
    const getRandomColor = () => {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    };

    // Loop through the rides and add markers for each pick-up and drop-off location
    rides.forEach(ride => {
        const { id, pick_location, drop_location, trip_type, offer, pick_time, return_time, start_date, end_date, role, status, note } = ride;

        // Construct the URL for the ride details page
        const rideDetailUrl = `/ride/${id}`; // Adjust the URL as needed for your routing structure

        // Prepare the popup content with additional ride details and a View Details button
        const popupContent = `
            <b>Route:</b> ${pick_location?.title} - ${drop_location?.title}<br>
            <b>Trip Type:</b> ${trip_type}<br>
            <b>Offer:</b> PKR ${offer} per person<br>
            <b>Role:</b> ${role}<br>
            <b>Pick Time:</b> ${pick_time}<br>
            <b>Return Time:</b> ${return_time}<br>
            <b>Note:</b> ${note || 'N/A'}<br><br>
            <a href="${rideDetailUrl}" target="_blank" class="btn btn-primary btn-sm text-white">View Details</a>
        `;

        // Add pick-up marker if location data is available
        if (pick_location?.lat && pick_location?.lng) {
            const pickmarker = L.marker([pick_location.lat, pick_location.lng]).addTo(map);
            pickmarker.bindPopup(`<b>Pick-up Location</b><br>${popupContent}`);
        }

        // Add drop-off marker if location data is available
        if (drop_location?.lat && drop_location?.lng) {
            const dropmarker = L.marker([drop_location.lat, drop_location.lng]).addTo(map);
            dropmarker.bindPopup(`<b>Drop-off Location</b><br>${popupContent}`);
        }

        // Draw a line (polyline) between pick and drop locations with a random color
        if (pick_location?.lat && pick_location?.lng && drop_location?.lat && drop_location?.lng) {
            const latlngs = [
                [pick_location.lat, pick_location.lng],
                [drop_location.lat, drop_location.lng]
            ];

            // Add the polyline with a random color
            const polyline = L.polyline(latlngs, { color: getRandomColor(), weight: 4 }).addTo(map);
        }
    });
</script>

@endsection
