<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeBuyer;
use Illuminate\Http\Request;

class RecipeBuyerController extends BaseController
{
    public function getRecipeBuyer(String $userId)
    {
        $freeRecipes = RecipeBuyer::where('user_id', $userId)
        ->where('type', 'free')
        ->with('recipe')
        ->get()
        ->pluck('recipe');

        return $this->sendResponse($freeRecipes, 200, 'Recipe Buyer retrieved successfully.');

        // return response()->json(['free_recipes' => $freeRecipes], 200);
    }
}
