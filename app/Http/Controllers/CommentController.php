<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\RideService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $rideService;
    protected $commentService;

    public function __construct(RideService $rideService, CommentService $commentService)
    {
        $this->rideService = $rideService;
        $this->commentService = $commentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($ride_id)
    {
        $ride = $this->rideService->getRideByIdWithComments($ride_id);
        return view('comment.index', compact('ride'));
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
    public function store(Request $request, $ride_id)
    {
        $comment_body = $request->body;
        $comment = $this->commentService->storeComment($ride_id,$comment_body);
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
    public function destroy(string $id)
    {
        //
    }
}
