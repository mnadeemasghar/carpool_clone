<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchAddressRequest;
use App\RepositoryInterfaces\AddressRepositoryInterface;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchAddressRequest $request)
    {
        $addresses = $this->addressRepository->getAddresses($request->title);
        
        return response()->success($addresses);
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
    public function store(SearchAddressRequest $request)
    {
        return response()->success(
            $this->addressRepository->getAddressByTitle($request->title,['lat' => $request?->lat ?? null, 'lng' => $request?->lng ?? null])
        );
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
