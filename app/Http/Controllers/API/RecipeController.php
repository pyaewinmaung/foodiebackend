<?php

namespace App\Http\Controllers\API;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeResource;
use App\Models\RecipeBuyer;
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
            'instruction' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'amount' => 'integer',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $image = 'images/'.time().'.'.$request->file('image')->extension();
        $request->file('image')->move(public_path('images'),$image);

        // $image = $request->file('image')->store('images', 'public');

        $recipe = Recipe::create(array_merge($input, ['user_id' => $userId],['image' => $image]));

        return $this->sendResponse($recipe, 201, 'Recipe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recipe = Recipe::with('user', 'category', 'comments')->find($id);

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
            'instruction' => 'required|string',
            'image' => 'nullable',
            'amount' => 'integer',
            'type' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $recipe->category_id = $input['category_id'];
        $recipe->title = $input['title'];
        $recipe->description = $input['description'];
        $recipe->instruction = $input['instruction'];
        // $recipe->image = $input['image'];
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
        $recipes = Recipe::with('category', 'user')->get();

        $data = RecipeResource::collection($recipes);

        return $this->sendResponse($data, 200, 'Get All Recipes successfully.');
    }

    public function search_recipes(Request $request)
    {
        $searchTerm = $request->input('title');

        $recipes = Recipe::where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%')
                ->get();

        $data = RecipeResource::collection($recipes);

        return $this->sendResponse($data, 200, 'Search Recipes successfully.');
    }

    public function getRecipesByUser($userId)
    {
        $recipes = Recipe::where('user_id', $userId)->get();

        if ($recipes->isEmpty()) {
            return response()->json(['error' => 'Recipes not found.'], 404);
        }

        $data = RecipeResource::collection($recipes);

        return $this->sendResponse($data, 200, 'Recipes Retrive Successfull.');
    }
}
