<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'recipe_id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'instruction'=> $this->instruction,
            'image' => asset($this->image)?? null,
            'amount' => $this->amount,
            'type' => ($this->type)?? null,
            'category_name' => $this->category->category,
            'user_name' => $this->user->name,
            'created_at' => $this->created_at,
            'udated_at' => $this->updated_at,
        ];
    }
}
