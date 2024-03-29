<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return $this->sendError('Categories not found.');
        }

        // $categoryResources = CategoryResource::collection($categories);

        return $this->sendResponse($categories, 200, 'Categories retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($id) {
            // Retrieve a specific category based on the provided $id
            $category = Category::with('recipes')->find($id);

            if (!$category) {
                return $this->sendError('Category not found.', 404);
            }

            // $categoryResource = new CategoryResource($category);

            return $this->sendResponse($category, 200, 'Category retrieved successfully.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
