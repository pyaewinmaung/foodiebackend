<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeBuyerResource;
use App\Models\Recipe;
use App\Models\RecipeBuyer;
use Illuminate\Http\Request;

class RecipeBuyerController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        $recipeBuyer = RecipeBuyer::create([
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
        ]);
        
        return $this->sendResponse($recipeBuyer, 201, 'Recipe buyer stored successfully');
        // return response()->json(['recipeBuyer' => $recipeBuyer, 'message' => 'Recipe buyer stored successfully'], 201);
    }

    public function getRecipeBuyer(String $userId, String $recipeId)
    {
        $recipeDetails = RecipeBuyer::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->whereHas('recipe', function ($query) {
                $query->where('type', 'free');
            })
            ->with(['recipe', 'user'])
            ->first();

        if (!$recipeDetails) {
            return $this->sendError('Recipe details not found.',[],404);
        }

        $data = new RecipeBuyerResource($recipeDetails);

        return $this->sendResponse($data, 200, 'Recipe details found.');
    }
}
