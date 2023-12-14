<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Meals_eaten;
use Illuminate\Http\Request;
use App\Http\Resources\Meal_data as Meal_data_resource;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get meal data not paginated
        $meal_data = Meal::all();

        // Return coolection of meals as a resource
        return Meal_data_resource::collection($meal_data);
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
    public function store()
    {
        //
    }

    /**
     * Add new meal to meal eaten.
     */
    public function add_meal_to_meal_eaten(Request $request)
    {

        $meal_eaten = new Meals_eaten;
        $meal_eaten->portion_size = 50;
        $meal_eaten->date_of_eat = $request->date;
        $meal_eaten->meal_id = $request->id;
        
        // get the name of the meal
        $meal_name = Meal::findOrFail($request->id)->name;

        if ($meal_eaten->save()) {
            return response()->json([
                'message' => $meal_name.' added'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal_name.' not added'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get a single meal data
        $meal_data = Meal::findOrFail($id);

        // Return single body data as a resource
        return new Meal_data_resource($meal_data);
    }

    /**
     * Display the meals based on the date the user currently sees.
     */
    public function show_meals_based_on_date(string $date)
    {
        $meal_data = Meal::all();
        $eaten_at_date = [];
        foreach ($meal_data as $id => $meal) {
            $tmp = $meal->meals_eaten()->get(); // get the meals eaten based on the meal id
            $eaten_at_date = array_merge($eaten_at_date, $tmp->where('date_of_eat', $date)->all()); // get the meals eaten based on the date

        }

        foreach ($eaten_at_date as $id => $meal) {
            $tmp = $meal->meals()->get(); // get the meals eaten based on the meal id
            $eaten_at_date[$id]['meal'] = $tmp->all(); // get the meals eaten based on the date
        }

        return $eaten_at_date;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove_meal_from_meal_eaten(string $id)
    {
        $meal_eaten = Meals_eaten::findOrFail($id);
        $meal_name = Meal::findOrFail($meal_eaten->meal_id)->name;
        if ($meal_eaten->delete()) {
            return response()->json([
                // instead of Meal add the meal name to the message
                'message' => $meal_name.' deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal_name.' not deleted'
            ], 400);
        }
    }
}
