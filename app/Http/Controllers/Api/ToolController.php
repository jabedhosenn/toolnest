<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ToolResource;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ToolController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'category' => ['sometimes', 'string', 'max:255'],
            'featured' => ['sometimes', 'in:true,false,1,0'],
            'popular' => ['sometimes', 'in:true,false,1,0'],
            'sort' => ['sometimes', 'in:sort_order,recent,name'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $query = $this->activeTools();

        if (isset($filters['category'])) {
            $query->whereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery
                ->where('slug', $filters['category']));
        }

        foreach (['featured' => 'is_featured', 'popular' => 'is_popular'] as $filter => $column) {
            if (array_key_exists($filter, $filters)) {
                $query->where($column, filter_var($filters[$filter], FILTER_VALIDATE_BOOLEAN));
            }
        }

        match ($filters['sort'] ?? 'sort_order') {
            'recent' => $query->orderByDesc('created_at')->orderByDesc('id'),
            'name' => $query->orderBy('name')->orderBy('id'),
            default => $query->orderBy('sort_order')->orderBy('id'),
        };

        return ToolResource::collection($query->paginate($filters['per_page'] ?? 12));
    }

    public function show(string $slug): ToolResource
    {
        $tool = $this->activeTools()
            ->where('slug', $slug)
            ->firstOrFail();

        return ToolResource::make($tool);
    }

    public function popular(Request $request): AnonymousResourceCollection
    {
        $perPage = $this->validatedPerPage($request);
        $tools = $this->activeTools()
            ->where('is_popular', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage);

        return ToolResource::collection($tools);
    }

    public function featured(Request $request): AnonymousResourceCollection
    {
        $perPage = $this->validatedPerPage($request);
        $tools = $this->activeTools()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage);

        return ToolResource::collection($tools);
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'q' => ['required', 'string', 'max:100'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);
        $term = '%'.$filters['q'].'%';

        $tools = $this->activeTools()
            ->where(function (Builder $query) use ($term): void {
                $query->where('name', 'like', $term)
                    ->orWhere('slug', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhereHas('category', fn (Builder $categoryQuery): Builder => $categoryQuery
                        ->where('name', 'like', $term))
                    ->orWhereHas('tags', fn (Builder $tagQuery): Builder => $tagQuery
                        ->where('name', 'like', $term)
                        ->orWhere('slug', 'like', $term));
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($filters['per_page'] ?? 12);

        return ToolResource::collection($tools);
    }

    private function activeTools(): Builder
    {
        return Tool::query()
            ->active()
            ->whereHas('category', fn (Builder $query): Builder => $query->active())
            ->with(['category', 'tags']);
    }

    private function validatedPerPage(Request $request): int
    {
        $filters = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        return $filters['per_page'] ?? 12;
    }
}
