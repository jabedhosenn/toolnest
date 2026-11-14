<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'category' => $this->whenLoaded(
                'category',
                fn (): CategoryResource => CategoryResource::make($this->category),
            ),
            'route_name' => $this->route_name,
            'component_identifier' => $this->component_identifier,
            'is_featured' => $this->is_featured,
            'is_popular' => $this->is_popular,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'tags' => $this->whenLoaded(
                'tags',
                fn (): array => $this->tags->pluck('name')->all(),
            ),
        ];
    }
}
