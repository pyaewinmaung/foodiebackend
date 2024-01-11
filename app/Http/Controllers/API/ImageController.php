<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends BaseController
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('images', 'public');

        if(!$path) {
            return $this->sendError('Image path not found.', [], 404);
        }

        $image = Image::create(['path' => $path]); // Change this to 'path'
        if(!$image) {
            return $this->sendError('Image path not found.', [], 404);
        }
        return response()->json(['image' => $image, 'message' => 'Image uploaded successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $path = Image::find($id);

        if (is_null($path)) {
            return $this->sendError('Image not found.');
        }

        return $this->sendResponse($path, 200, 'Image Path retrieved successfully.');
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
        $image = Image::find($id);

        if (!$image) {
            return $this->sendError('Image not found.', [], 404);
        }

        // Delete the image file from the public disk
        Storage::disk('public')->delete($image->path);

        // Delete the record from the database
        $image->delete();

        return $this->sendResponse([], 200, 'Image and path deleted successfully.');
    }
}
