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
            'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $path = $request->file('path')->store('images', 'public');
        $path = 'images/'.time().'.'.$request->file('path')->extension();
        $request->file('path')->move(public_path('images'),$path);

        if (!$path) {
            return $this->sendError('Failed to store the image.', [], 500);
        }

        $image = Image::create(['path' => $path]);

        $imageUrl = asset($path); // Get the public URL of the stored image

        return $this->sendResponse(['image' => $image, 'image_url' => $imageUrl], 201, 'Image uploaded successfully');
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

        $imageUrl = asset($path->path);
        return $this->sendResponse(['image' => $path, 'image_url' => $imageUrl],200, 'Image Path retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
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
