<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BodyData};

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

// List all of the body data
Route::get('body', [BodyData::class, 'index']);

// List single body data
Route::get('body/{id}',  [BodyData::class, 'show']);

// Create new body data
Route::post('body',  [BodyData::class, 'store']);

// Update body data
Route::put('body',  [BodyData::class, 'store']);

// Delete body data
Route::delete('body/{id}',  [BodyData::class, 'destroy']);