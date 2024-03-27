<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItineraireController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EndroitAVisiterController;

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



// Routes pour l'authentification des utilisateurs
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');

// Routes pour les itinéraires
Route::post('/itineraires', [ItineraireController::class, 'create'])->middleware('auth:api');
Route::post('/itineraires/{itineraireId}/addDestination', [ItineraireController::class, 'addDestination'])->middleware('auth:api');
Route::post('/itineraires/{itineraireId}/addToVisitList', [ItineraireController::class, 'addToVisitList'])->middleware('auth:api');
Route::get('/itineraires', [ItineraireController::class, 'index']);
Route::get('/itineraires/search', [ItineraireController::class, 'search']);

// Routes pour les destinations
Route::post('/destinations/{itineraireId}', [DestinationController::class, 'addDestination'])->middleware('auth:api');

// Routes pour les endroits à visiter
Route::post('/endroitsAVisiter/{destinationId}', [EndroitAVisiterController::class, 'addEndroitAVisiter'])->middleware('auth:api');
Route::get('/endroitsAVisiter/{destinationId}', [EndroitAVisiterController::class, 'getEndroitsAVisiter']);
Route::put('/endroitsAVisiter/{endroitAVisiterId}', [EndroitAVisiterController::class, 'updateEndroitAVisiter'])->middleware('auth:api');
Route::delete('/endroitsAVisiter/{endroitAVisiterId}', [EndroitAVisiterController::class, 'deleteEndroitAVisiter'])->middleware('auth:api');

