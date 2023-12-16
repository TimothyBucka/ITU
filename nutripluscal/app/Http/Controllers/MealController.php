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
        // get the meals that are not from restaurants, paginated
        $meal_data = Meal::where('restaurant_id', null)->paginate(10);

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
     * Store a newly crated meal.
     */
    public function store(Request $request)
    {
        //$is_negative = false;

        $meal = new Meal;
        $meal->name = $request->name;
        $meal->calories = $request->calories;
        $meal->proteins = $request->proteins;
        $meal->carbs = $request->carbs;
        $meal->fats = $request->fats;
        $meal->fibers = $request->fibers;
        $meal->photo_path = $request->photo_path;
        $meal->restaurant_id = null;

        // // chceck if the numbers are not negative
        // foreach ($meal->getAttributes() as $key => $value) {
        //     if ($key == 'photo_path' || $key == 'restaurant_id') {
        //         continue;
        //     }

        //     // reset the negative numbers all to 0
        //     if ($value < 0) {
        //         $meal->$key = 0;
        //         $is_negative = true;
        //     }
        // }

        // if ($is_negative) {
        //     return response()->json([
        //         'message' => 'Numbers cannot be negative'
        //     ], 400);
        // }

        //check if the meal already exists
        $meal_exists = Meal::where('name', $meal->name)->first();
        if ($meal_exists) {
            return response()->json([
                'message' => $meal->name . ' already exists'
            ], 400);
        }

        if ($meal->save()) {
            return response()->json([
                'message' => $meal->name . ' created'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal->name . ' not created'
            ], 400);
        }
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
        $meal_eaten->meal_time = $request->time_of_meal;

        // get the name of the meal
        $meal_name = Meal::findOrFail($request->id)->name;

        if ($meal_eaten->save()) {
            return response()->json([
                'message' => $meal_name . ' added'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal_name . ' not added'
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
            $eaten_at_date = array_merge($eaten_at_date, $tmp->where('date_of_eat', $date)->all()); // get the meals eaten based on the date and time of the meal
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
     * Update the meal in the meals, which was created by the user.
     */
    public function update(Request $request, string $id)
    {
        $existing = Meal::findOrFail($id);

        $name = $request->input('name');
        $photo_path = $request->input('photo_path');
        $calories = $request->input('calories');
        $proteins = $request->input('proteins');
        $carbs = $request->input('carbs');
        $fats = $request->input('fats');
        $fibers = $request->input('fibers');

        // chceck if the numbers are not negative
        if ($calories < 0 || $proteins < 0 || $carbs < 0 || $fats < 0 || $fibers < 0) {
            return response()->json([
                'message' => 'Numbers cannot be negative'
            ], 400);
        }

        // check if the meal already exists, chceck all parameters
        $meal_exists = Meal::where('name', $name)->where('calories', $calories)->where('proteins', $proteins)->where('carbs', $carbs)->where('fats', $fats)->where('photo_path', $photo_path)->where('fibers', $fibers)->first();
        if ($meal_exists) {
            return response()->json([
                'message' => $name . ' already exists'
            ], 400);
        }

        $existing->name = $name ? $name : $existing->name; // if name is not null, then update the name
        $existing->photo_path = $photo_path ? $photo_path : $existing->photo_path;
        $existing->calories = $calories ? $calories : $existing->calories;
        $existing->proteins = $proteins ? $proteins : $existing->proteins;
        $existing->carbs = $carbs ? $carbs : $existing->carbs;
        $existing->fats = $fats ? $fats : $existing->fats;
        $existing->fibers = $fibers ? $fibers : $existing->fibers;

        if ($existing->save()) {
            return response()->json([
                'message' => $existing->name . ' updated'
            ], 200);
        } else {
            return response()->json([
                'message' => $existing->name . ' not updated'
            ], 400);
        }
    }

    /**
     * Remove the meal from the meals.
     */
    public function remove_meal(string $id)
    {
        // check if the meal is already used in the meal_eaten
        $meal_eaten = Meals_eaten::where('meal_id', $id)->first();
        if ($meal_eaten) {
            return response()->json([
                'message' => 'Meal is already used in the Calendar'
            ], 400);
        }

        $meal = Meal::findOrFail($id);
        $meal_name = $meal->name;
        if ($meal->delete()) {
            return response()->json([
                'message' => $meal_name . ' deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal_name . ' not deleted'
            ], 400);
        }
    }

    /**
     * Remove the meal from the meal_eaten.
     */
    public function remove_meal_from_meal_eaten(string $id)
    {
        $meal_eaten = Meals_eaten::findOrFail($id);
        $meal_name = Meal::findOrFail($meal_eaten->meal_id)->name;
        if ($meal_eaten->delete()) {
            return response()->json([
                // instead of Meal add the meal name to the message
                'message' => $meal_name . ' deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal_name . ' not deleted'
            ], 400);
        }
    }
}
