<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'recipe_id' => $this->recipe->id,
            'user_id' => $this->user->id,
            'user-name' => $this->user->name,
            'recipe_name' => $this->recipe->title,
            'image' => $this->user->image,
            'comment_id' => $this->id,
            'comment' => $this->comment,
        ];
    }
}
