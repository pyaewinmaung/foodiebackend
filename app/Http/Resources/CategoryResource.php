<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category_id' => $this->id,
            'category_name' => $this->category,
            'recipe_id' => $this->recipe->id,
            'recipe_name' => $this->recipe->title,
            'description' => $this->recipe->description,
            'instruction' => $this->recipe->instruction,
            'image' => asset($this->recipe->image)?? null,
            'amount' => $this->recipe->amount,
            'type' => $this->recipe->type,

        ];
    }
}
