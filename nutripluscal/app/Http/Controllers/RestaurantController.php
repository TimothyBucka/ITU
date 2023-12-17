<?php
// ######################################### FILE: RestaurantController.php ###############################################
// Authors: Timotej Bucka (xbucka00)
// ############################################################################################################### 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurants;
use App\Http\Resources\Restaurants_data as Restaurants_data_resource;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rest_data = Restaurants::paginate(10);

        return Restaurants_data_resource::collection($rest_data);
    }

    public function get_last_visited()
    {
        // get 5 last visited restaurants
        $rest_data = Restaurants::orderBy('last_visited', 'desc');
        if ($rest_data->count() > 5) {
            $rest_data = $rest_data->take(5)->get();
        } else {
            $rest_data = $rest_data->get();
        }

        return Restaurants_data_resource::collection($rest_data);
    }

    public function get_most_visited()
    {
        // get 5 most visited restaurants
        $rest_data = Restaurants::orderBy('visited', 'desc');
        if ($rest_data->count() > 5) {
            $rest_data = $rest_data->take(5)->get();
        } else {
            $rest_data = $rest_data->get();
        }

        return Restaurants_data_resource::collection($rest_data);
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
        $rest_data = Restaurants::with(['meals' => function ($q) {
            $q->orderBy('name', 'asc');
        }])->findOrFail($id);

        return new Restaurants_data_resource($rest_data);
    }

    /**
     * Search restaurants by query.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $rest_data = Restaurants::where('name', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%')
                    ->orWhere('type', 'like', '%' . $query . '%')
                    ->orderBy('name') // Sort restaurants by name
                    ->get();

        return Restaurants_data_resource::collection($rest_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurants $restaurants)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurants $restaurants)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurants $restaurants)
    {
        //
    }
}
