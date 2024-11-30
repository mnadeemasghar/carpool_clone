<?php

namespace App\Http\Middleware;

use App\Models\Ride;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRideOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rideId = $request->route('ride_id');
        $ride = Ride::find($rideId);

        // Check if ride exists and if the authenticated user is the owner
        if (!$ride || $ride->user_id != Auth::id()) {
            // If the user does not own the ride, deny access
            return redirect()->back()->with('danger', 'Unauthorized');
        }

        return $next($request);
    }
}
