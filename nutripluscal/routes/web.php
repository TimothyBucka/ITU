<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodyData;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/restaurants', function () {
    return view('welcome');
});
Route::get('/restaurants/{id}', function () {
    return view('welcome');
});

Route::get('/y_meals', function () {
    return view('welcome');
});

Route::get('/calendar', function () {
    return view('welcome');
});

Route::get('/account', function () {
    return view('welcome');
});

Route::get('/search_meals/{date}/{meal_type}', function () {
    return view('welcome');
});

// Route::get('/recipes', [UserController::class, 'show'])->name('/recipes');
// Route::get('/calendar', [UserController::class, 'show'])->name('/calendar');

//Route::get('/', [BodyData::class, 'index']);

//Route::get('/test-db', [BodyData::class, 'testDatabaseConnection']);