@extends('layouts.website')

@section('content')
    <!-- Ride Request Success Card -->
    <div class="card shadow mb-5">
        <div class="card-body">
            @if ($ride)
                <h2 class="card-title text-center text-success mb-3"><i class="bi bi-check-circle-fill"></i> Ride Request Successful</h2>
                
                <p class="card-text text-center text-muted">Enhance the visibility of your ride by adding additional stops, making it easier for more users to join and benefit from your route.</p>

                <div class="d-flex justify-content-center">
                    <a class="cta-button" href="{{ route('stop.index',['ride_id'=>$ride->id]) }}"><i class="bi bi-geo-alt-fill"></i> Add Stops</a>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center mt-4">
                    <!-- WhatsApp Share Button -->
                    <a class="btn btn-success mb-2 mb-md-0 me-md-3 d-flex align-items-center justify-content-center" 
                       href="https://api.whatsapp.com/send?text=I%20just%20requested%20a%20ride%20on%20Carpool!%20Check%20it%20out%20here:%20{{ urlencode('https://carpoollahore.com/ride/'.$ride->id) }}" 
                       target="_blank">
                        <i class="bi bi-whatsapp me-2"></i> Share on WhatsApp
                    </a>
                
                    <!-- LinkedIn Share Button -->
                    <a class="btn mb-2 mb-md-0 me-md-3 d-flex align-items-center justify-content-center" 
                       style="background-color: #0077b5; color: white;" 
                       href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode('https://carpoollahore.com/ride/'.$ride->id) }}" 
                       target="_blank">
                        <i class="bi bi-linkedin me-2"></i> Share on LinkedIn
                    </a>
                
                    <!-- Twitter Share Button -->
                    <a class="btn mb-2 mb-md-0 me-md-3 d-flex align-items-center justify-content-center" 
                       style="background-color: #1DA1F2; color: white;" 
                       href="https://twitter.com/intent/tweet?text=I%20just%20requested%20a%20ride%20on%20Carpool!%20Join%20me%20and%20explore%20safe%20rides:%20{{ urlencode('https://carpoollahore.com/ride/'.$ride->id) }}" 
                       target="_blank">
                        <i class="bi bi-twitter me-2"></i> Share on Twitter
                    </a>
                
                    <!-- Facebook Share Button -->
                    <a class="btn d-flex align-items-center justify-content-center" 
                       style="background-color: #4267B2; color: white;" 
                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode('https://carpoollahore.com/ride/'.$ride->id) }}" 
                       target="_blank">
                        <i class="bi bi-facebook me-2"></i> Share on Facebook
                    </a>
                </div>


                @if ($ride->user->email_verified_at == null)
                    <p class="card-text text-danger mt-4">
                        To ensure your ride is made available on the platform, please complete the necessary steps below.
                    </p>

                    <ul class="list-group list-group-flush text-start my-4">
                        <li class="list-group-item border-0" style="background-color: #f8f9fa;">
                            <span class="text-muted">⚠️</span> <strong class="text-danger">Email Verification Required:</strong> To make your ride available on the web portal, verify your email by clicking the verification link sent to the email address provided during the ride request.
                        </li>
                    </ul>
                @endif
            @else
                <h2 class="card-title text-center text-danger"><i class="bi bi-bookmark-x-fill"></i></h2>
                <p class="card-text text-center text-danger" >The ride you requested could not be found or is not permitted to be displayed.</p>
                
                <div class="d-flex justify-content-center">
                    <a class="cta-button" href="{{ route('ride.create') }}"><i class="bi bi-plus"></i> Create New Ride</a>
                </div>
            @endif
        </div>
    </div>
@endsection
