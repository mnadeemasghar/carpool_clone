<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStopRequest;
use App\Models\Stop;
use App\Services\AddressService;
use App\Services\RideService;
use App\Services\StopService;
use Illuminate\Http\Request;

class StopController extends Controller
{
    protected $rideService;
    protected $stopService;
    protected $addressService;

    public function __construct(RideService $rideService, StopService $stopService, AddressService $addressService)
    {
        $this->rideService = $rideService;
        $this->stopService = $stopService;
        $this->addressService = $addressService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($ride_id)
    {
        $ride = $this->rideService->getRideByIdWithStops($ride_id);
        return view('stop.index', compact('ride'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStopRequest $request, $ride_id)
    {
        $address = $this->addressService->getAddressByTitle($request->address);
        $stop = $this->stopService->addStopToRide($ride_id, $address->id, Stop::TYPE_STOP);

        if ($stop) {
            session()->flash('success', 'Stop added successfully!');
        } else {
            session()->flash('danger', 'Failed to add stop.');
        }
        
        return redirect()->back();
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
    public function destroy($ride_id, string $id)
    {
        $this->stopService->deleteById($id);
        return redirect()->back();
    }
}
