<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\InstructionController;
use App\Http\Controllers\API\RecipeBuyerController;
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
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/get_recipes',[RecipeController::class,'get_recipes']);

Route::group(['middleware' => 'auth:sanctum'], function (){

    Route::get('/getuser', [RegisterController::class, 'get_user']);
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::apiResource('/recipes', RecipeController::class);
    Route::post('/search',[RecipeController::class,'search_recipes']);

    Route::apiResource('/categories', CategoryController::class);
    Route::get('/free-recipe/{userId}/{recipeId}',[RecipeBuyerController::class,'getRecipeDetails']);
    Route::post('/free-recipe/store',[RecipeBuyerController::class,'store']);
    Route::get('/free-recipe/show/{userId}',[RecipeBuyerController::class,'show']);

    Route::get('/getbuy/{userId}',[RecipeBuyerController::class,'getBuy']);

    Route::apiResource('/image', ImageController::class);
    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/instructions', InstructionController::class);
});
