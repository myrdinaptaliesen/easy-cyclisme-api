<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\DisciplineController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\Cyclists_categoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Club
Route::apiResource('club', ClubController::class)
    ->middleware('auth');

// Logo URL
Route::get('logo/{filename}', [LogoController::class,'getLogo'])
    ->name('logo.getLogo')
    ->middleware('auth'); 

// Competition
Route::apiResource('competition', CompetitionController::class)
    ->middleware('auth');

// Discipline
Route::apiResource('discipline', DisciplineController::class)
    ->middleware('auth');

// Image URL
Route::get('image/{filename}', [ImageController::class,'getImage'])
    ->middleware('auth')
    ->name('image.getImage');

// Catégories de cyclistes
Route::apiResource('cyclists_category', Cyclists_categoryController::class)
    ->middleware('auth');

// Image URL
Route::get('search', [CompetitionController::class,'search']);
