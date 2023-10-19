<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Body_data_model;
use App\Http\Resources\Body_data as Body_data_resource;

class BodyData extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get body data
        $body_data = Body_data_model::paginate(10);

        // Return coolection of body data as a resource
        return Body_data_resource::collection($body_data);
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
        // Get a single body data
        $body_data = Body_data_model::findOrFail($id); // if not found, return 404 and id is from our route

        // Return single body data as a resource
        return new Body_data_resource($body_data);
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
