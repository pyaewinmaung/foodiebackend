<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\InstructionController;
use App\Http\Controllers\API\RecipeController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [RegisterController::class, 'login']);
Route::post('/users', [RegisterController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::apiResource('/recipes', RecipeController::class);
    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/instructions', InstructionController::class);
});
