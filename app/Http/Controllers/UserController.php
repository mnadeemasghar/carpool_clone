<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(User $user)
    {
        return view('user.show',compact('user'));
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

    public function referral(){

        // referrals
        $referrals = User::where('referred_by',Auth::user()->id)->get();
        
        // Top 10 leaders with refer_count using raw query and join
        $leaders = DB::table('users as u')
        ->select('u.id', 'u.name', DB::raw('COUNT(r.id) as refer_count'))
        ->leftJoin('users as r', 'u.id', '=', 'r.referred_by')
        ->whereNotNull('r.email_verified_at')
        ->groupBy('u.id', 'u.name')
        ->orderBy('refer_count', 'DESC')
        ->limit(10)
        ->get();

        return view('referral.index',compact('referrals','leaders'));
    }
}
