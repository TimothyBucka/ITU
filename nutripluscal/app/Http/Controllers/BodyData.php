<?php

namespace App\Http\Controllers;

use DateTime;
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
     * Get the dates for one year ahead.
     */
    public function generate_dates()
    {
        $current_date = new DateTime(); // get the date (today)
        $start_date = clone $current_date;
        $end_date = clone $current_date;
        $end_date->modify('-10 day'); // +1 year from current day
    
        $dates = [];
        $currentDate = $start_date;
        while ($currentDate >= $end_date) {
            array_push($dates, $this->formatDate(clone $currentDate)); // clone the date and push it to the array
            $currentDate->modify('-1 day');
        }

       $dates = array_reverse($dates); // reverse the array
       
        return response()->json([
            'dates' => $dates
        ], 200);
    }

    /**
     * Format the dates
     */
    public function formatDate($date)
    {
        return $date->format('l jS \of F Y'); // Monday 8 of August 2005 03:12:46 PM for example the is for escaping the chars that have special meaning in date format like e.g. "of"
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $body_data = $request->isMethod('put') ?
            Body_data_model::findOrFail($request->body_data_id) : new Body_data_model; // chceck for put req. include id of body data else create new body data

        $body_data->id = $request->input('body_data_id');
        $body_data->height = $request->input('height');
        $body_data->weight = $request->input('weight');
        $body_data->age = $request->input('age');
        $body_data->goal_target = $request->input('goal_target');
        $body_data->bmi = $request->input('bmi');

        if ($body_data->save()) {
            return new Body_data_resource($body_data);
        } else {
            return response()->json([
                'error' => 'Unable to save body data'
            ], 500);
        }
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
        $existing = Body_data_model::findOrFail($id);

        $height = $request->input('height');
        $weight = $request->input('weight');
        $age = $request->input('age');
        $goal_target = $request->input('goal_target');

        $existing->height = $height ? $height : $existing->height;
        $existing->weight = $weight ? $weight : $existing->weight;
        $existing->age = $age ? $age : $existing->age;
        $existing->goal_target = $goal_target ? $goal_target : $existing->goal_target;

        $bmi = Body_data_model::calculateBMI($existing->height, $existing->weight);
        $existing->bmi =  $bmi ? $bmi : $existing->bmi;

        if ($existing->save()) {
            return $existing;
        } else {
            return response()->json([
                'error' => 'Unable to update body data'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get a single body data
        $body_data = Body_data_model::findOrFail($id);

        if ($body_data->delete()) {
            return new Body_data_resource($body_data);
        } else {
            return response()->json([
                'error' => 'Unable to delete body data'
            ], 500);
        }
    }
}
