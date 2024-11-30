<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Traits\Sortable;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use Sortable;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $addresses = Address::has('rides')->withCount('rides')->where(['lat' => null, 'lng' => null])->orderBy('rides_count','desc')->get();
        return view('admin.address.index',compact('addresses'));
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
    public function store(Request $request)
    {
        //
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
        Address::where('id',$id)->update([
            "lat" => $request->lat,
            "lng" => $request->lng,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
