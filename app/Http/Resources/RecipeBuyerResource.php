<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeBuyerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'recipe_id' => $this->recipe->id,
            'recipe_title' => $this->recipe->title,
            'type'=>$this->recipe->type,
        ];
    }
}
