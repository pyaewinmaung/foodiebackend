<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class CommentController extends BaseController
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

        $userId = Auth::user()->id;

        $validator = Validator::make($input, [
            'recipe_id'=>'required',
            'comment' => 'required|string'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $comment = Comment::create(array_merge($input, ['user_id' => $userId]));

        return $this->sendResponse($comment, 201, 'Comment created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comments = Comment::where('recipe_id', $id)
                ->with('recipe','user')
                ->get();

        $commentResources = CommentResource::collection($comments);

        if ($commentResources->isEmpty()) {
            return $this->sendError('Comments not found.');
        }

        return $this->sendResponse($commentResources, 200, 'Comments retrieved successfully.');
        }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            // 'recipe_id' => 'required',
            'comment' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // $comment->recipe_id = $input['recipe_id'];
        $comment->comment = $input['comment'];

        $comment->save();

        return $this->sendResponse($comment, 200, 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        $comment->delete();

        return $this->sendResponse($comment, 200, 'Comment deleted successfully.');
    }
}
