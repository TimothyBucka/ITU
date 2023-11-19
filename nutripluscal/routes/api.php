<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BodyData};
use App\Http\Controllers\{RestaurantController};

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

//-------------------RESTAURANTS-------------------//

// List all of the restaurants
Route::get('restaurants', [RestaurantController::class, 'index']);

// List single body data
Route::get('restaurants/{id}',  [RestaurantController::class, 'show']);