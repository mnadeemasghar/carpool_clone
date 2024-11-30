<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Sortable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Sortable;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Users";

        $model = User::query();

        $sortableColumns = ['id','email_verified_at','name','email','phone'];
        $query = $model->select($sortableColumns);
        
        $data = $this->getSortedQuery($request, $query, $sortableColumns)->withCount(['rides'])->paginate('10');

        return view('table-page',compact('title','data'));
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
