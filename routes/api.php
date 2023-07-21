<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController; 


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
Route::get(
	'properties', 
	[PropertyController::class, 'index']
)->name('api.properties.index');

Route::post(
	'properties', 
	[PropertyController::class, 'store']
)->name('api.properties.store');

Route::put( 
	'properties/{property}', 
	[PropertyController::class, 'update']
)->name('api.properties.update');

Route::delete( 
	'properties', 
	[PropertyController::class, 'destroy'] 
)->name('api.properties.destroy');
