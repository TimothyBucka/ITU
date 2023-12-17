<?php
// ######################################### FILE: restaurants.vue ###############################################
// Authors: Adam Pap (xpapad11)
// ############################################################################################################### 

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Restaurants;
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
    {   $img_null = 0;

        $meal = new Meal;
        $meal->name = $request->name;
        $meal->calories = $request->calories;
        $meal->proteins = $request->proteins;
        $meal->carbs = $request->carbs;
        $meal->fats = $request->fats;
        $meal->fibers = $request->fibers;
        $meal->restaurant_id = null;
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);
            $meal->photo_path = $request->file('photo')->getClientOriginalName();
            $meal->photo_path = time() . '_' . $meal->photo_path; //new photo name based on time
            $request->photo->move(public_path('img'), $meal->photo_path); // move the photo to the public/img folder
        }else
        {
            $img_null = 1;
            $meal->photo_path = 'img_placeholder.jpg';
        }

        //check if the meal already exists
        $meal_exists = Meal::where('name', $meal->name)->first();
        if ($meal_exists) {
            return response()->json([
                'message' => $meal->name . ' already exists'
            ], 400);
        }

        if($img_null == 1)
        {
            if ($meal->save()) {
                return response()->json([
                    'message' => $meal->name . ' created',
                    'photo_path' => asset('img/' . $meal->photo_path),
                ], 200);
            } else {
                return response()->json([
                    'message' => $meal->name . ' not created'
                ], 400);
            }
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
        $meal_eaten->portion_size = $request->portion_size;
        $meal_eaten->date_of_eat = $request->date;
        $meal_eaten->meal_id = $request->id;
        $meal_eaten->meal_time = $request->type_of_meal;

        // get the name of the meal
        $meal = Meal::findOrFail($request->id);

        // update restaurant visits
        if ($meal->restaurant_id != null) {
            $restaurant = Restaurants::findOrFail($meal->restaurant_id);
            $restaurant_last_visited = $restaurant->last_visited;
            if ($restaurant_last_visited == null || $restaurant_last_visited < $meal_eaten->date_of_eat) {
                $restaurant->last_visited = $meal_eaten->date_of_eat;
            }
            $restaurant->visited = $restaurant->visited + 1;
            $restaurant->save();
        }

        if ($meal_eaten->save()) {
            return response()->json([
                'message' => $meal->name . ' added'
            ], 200);
        } else {
            return response()->json([
                'message' => $meal->name . ' not added'
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
        $name = $request->name;
        $calories = $request->calories;
        $proteins = $request->proteins;
        $carbs = $request->carbs;
        $fats = $request->fats;
        $fibers = $request->fibers;

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]);
            $photo_path = $request->file('photo')->getClientOriginalName();
            $photo_path = time() . '_' . $photo_path; //new photo name based on time
            $request->photo->move(public_path('img'), $photo_path); // move the photo to the public/img folder

            //delete the old photo
            $old_photo_path = $existing->photo_path;
            if ($old_photo_path != null) {
                unlink(public_path('img/' . $old_photo_path));
            }
        }
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
         //delete the old photo

        if ($meal->photo_path != null && $meal->photo_path != 'img_placeholder.jpg') {
            $old_photo_path = $meal->photo_path;
            if ($old_photo_path != null) {
                unlink(public_path('img/' . $old_photo_path));
            }
        }
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

    public function recommended_meals(Request $request)
    {
        $calories = $request->input('calories');
        $proteins = $request->input('proteins');
        $carbs = $request->input('carbs');
        $fats = $request->input('fats');
        $fibers = $request->input('fibers');
        $wantedCalories = $request->input('wantedCalories');
        $wantedProteins = $request->input('wantedProteins');
        $wantedCarbs = $request->input('wantedCarbs');
        $wantedFats = $request->input('wantedFats');
        $wantedFibers = $request->input('wantedFibers');
        $numberOfMeals = $request->input('numberOfMeals');
        // get all meals
        $meals = Meal::all();
        $recommended_meals = [];
        $maxMeals=4;

        $proteinGoal = $wantedProteins-$proteins;
        $carbsGoal = $wantedCarbs-$carbs;
        $fatsGoal = $wantedFats-$fats;
        $fibersGoal = $wantedFibers-$fibers;
        $caloriesGoal = $wantedCalories-$calories;
        $mealGoal = $maxMeals-$numberOfMeals;

        $goodMeals = [];
        $totalDifference = 0;

        foreach ($meals as $meal) {
            $goodMeals[] = $meal;
        }
        
        if (count($goodMeals) < $mealGoal) {
            $mealGoal = count($goodMeals);
        }       

        $mealAndDifference = [];

        foreach ($goodMeals as $meal) {
            $totalDifference = (abs($meal->calories - $caloriesGoal))/$mealGoal;
            $totalDifference += (abs($meal->proteins - $proteinGoal))/$mealGoal;
            $totalDifference += (abs($meal->carbs - $carbsGoal))/$mealGoal;
            $totalDifference += (abs($meal->fats - $fatsGoal))/$mealGoal;
            $totalDifference += (abs($meal->fibers - $fibersGoal))/$mealGoal;
            $mealAndDifference[] = [$meal, $totalDifference];
        }

        usort($mealAndDifference, function($a, $b) {
            return $a[1] <=> $b[1];
        });


        for ($i=0; $i < $mealGoal; $i++) { 
            $recommended_meals[] = $mealAndDifference[$i][0];
        }
        
        return $recommended_meals;
    }
}
