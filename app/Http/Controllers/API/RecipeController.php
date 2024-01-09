<?php

namespace App\Http\Controllers\API;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecipeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);

        $userId = Auth::user()->id;

        $validator = Validator::make($input, [
            'category_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable',
            'amount' => 'required|integer',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $recipe = Recipe::create(array_merge($input, ['user_id' => $userId]));

        return $this->sendResponse($recipe, 201, 'Recipe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::find($id);

        if (is_null($recipe)) {
            return $this->sendError('Recipe not found.');
        }

        return $this->sendResponse($recipe, 200, 'Recipe retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
           'category_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable',
            'amount' => 'required|integer',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $recipe->category_id = $input['category_id'];
        $recipe->title = $input['title'];
        $recipe->description = $input['description'];
        $recipe->image = $input['image'];
        $recipe->amount = $input['amount'];
        $recipe->type = $input['type'];

        $recipe->save();

        return $this->sendResponse($recipe, 200, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $recipe = Recipe::find($id);

        $recipe->delete();

        return $this->sendResponse($recipe, 200, 'Recipe deleted successfully.');
    }

    public function get_recipes(Request $request)
    {
        $recipes = Recipe::all();

        return $this->sendResponse($recipes, 200, 'Get All Recipes successfully.');
    }
}
