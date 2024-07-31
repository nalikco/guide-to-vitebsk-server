<?php

declare(strict_types=1);

namespace App\Http\Resources\Places;

use App\Models\PlaceCategory;
use App\Models\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @property int $id
 * @property ?PlaceCategory $parent
 * @property string $name
 * @property Upload $image
 * @property Carbon $created_at
 */
class PlaceCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent' => $this->parent ? new PlaceCategoryResource($this->parent) : null,
            'name' => $this->name,
            'image' => $this->image->public_path,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
