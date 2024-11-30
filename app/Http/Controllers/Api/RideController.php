<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRideRequest;
use App\Models\Ride;
use App\RepositoryInterfaces\AddressRepositoryInterface;
use App\RepositoryInterfaces\RideRepositoryInterface;
use Illuminate\Http\Request;

class RideController extends Controller
{
    protected $rideRepository;
    protected $addressRepository;

    public function __construct(RideRepositoryInterface $rideRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->rideRepository = $rideRepository;
        $this->addressRepository = $addressRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rides = $this->rideRepository->getSearchedRides($request);
        return response()->success($rides);
    }

    /**
     * Get ride by user
     */
    public function myRides(Request $request)
    {
        return response()->success($this->rideRepository->getRideByUserId($request->user()->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRideRequest $request)
    {
        $data = $request->all();
        $user_id = $request->user()->id;

        $data['role'] = Ride::ROLE_PASSENGER;

        $ride = $this->rideRepository->createNewRideByUserId($data, $user_id);
        $ride = $ride->refresh();

        return response()->success($ride);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
