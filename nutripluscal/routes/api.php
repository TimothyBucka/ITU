<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodyData;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MealController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//-------------------BODY DATA-------------------//

// List all of the body data
Route::get('body', [BodyData::class, 'index']);

// Create new body data
Route::post('body',  [BodyData::class, 'store']);

// List single body data
Route::get('body/{id}',  [BodyData::class, 'show']);

// Update body data
Route::put('body/{id}',  [BodyData::class, 'update']);

// Delete body data
Route::delete('body/{id}',  [BodyData::class, 'destroy']);

// Get the dates for one year ahead.
Route::get('/generate_dates',  [BodyData::class, 'generate_dates']);

//-------------------RESTAURANTS-------------------//

// List all of the restaurants
Route::get('restaurants', [RestaurantController::class, 'index']);

// List single body data
Route::get('restaurants/{id}',  [RestaurantController::class, 'show']);

//-------------------MEAL-------------------//

// List all of the meals
Route::get('meals', [MealController::class, 'index']);

// List single meal (for future use)
Route::get('meals/{id}',  [MealController::class, 'show']);

// List meals based on the date
Route::get('meals/date/{date}',  [MealController::class, 'show_meals_based_on_date']);

// Add meal to meal eaten
Route::post('meals/eaten',  [MealController::class, 'add_meal_to_meal_eaten']);

// Remove meal from meal eaten
Route::post('meals/eaten/delete/{id}',  [MealController::class, 'remove_meal_from_meal_eaten']);

// Remove meal from the meala
Route::post('meals/delete/{id}',  [MealController::class, 'remove_meal']);

// Add a new meal (from your meals)
Route::post('create/meal',  [MealController::class, 'store']);

// Update meal in the meals
Route::put('update/created_meals/{id}',  [MealController::class, 'update']);