<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallet_ids = Wallet::where('user_id',Auth::user()->id)->get()->pluck('id');
        $wallets = Wallet::where('user_id',Auth::user()->id)->get();
        $wallet_entries = WalletEntry::whereIn('wallet_id',$wallet_ids)->with('wallet')->orderBy('created_at','DESC')->paginate(10);
        return view('wallet.index',compact('wallet_entries','wallets'));
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
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }

    public function howToToup(){
        return view('wallet.topup');
    }
}
