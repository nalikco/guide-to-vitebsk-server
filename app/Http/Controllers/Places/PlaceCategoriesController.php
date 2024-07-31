<?php

declare(strict_types=1);

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Http\Resources\Places\PlaceCategoryCollection;
use App\Models\PlaceCategory;
use Illuminate\Http\Request;

class PlaceCategoriesController extends Controller
{
    public function __invoke(Request $request): PlaceCategoryCollection
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 15);

        $categories = PlaceCategory::query()
            ->withCount('views')
            ->latest('views_count')
            ->paginate($limit, page: $page);

        return new PlaceCategoryCollection($categories);
    }
}
