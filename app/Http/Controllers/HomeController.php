<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $items = $this->buildCollectionFromSearch($request->query('category'), $request->query('price_range'), $request->query('search'));

        return Inertia::render('home/Index', [
            'items' => $items,
            'categories' => ItemCategory::all(),
            'filter' => [
                // TODO: cache the _price's
                'min_price' => round(Item::min('price'), 2),
                'avg_price' => round(Item::avg('price'), 2),
                'max_price' => round(Item::max('price'), 2),
                'price_range' => $request->query('price_range') ?? null,
                'category' => $request->query('category') ?? null,
                'search' => $request->query('search') ?? null,
            ],
        ]);
    }

    private function buildCollectionFromSearch($category, $price_range, $search)
    {
        $query = Item::with(['item_category', 'supplier']);

        if (isset($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if (isset($category)) {
            $query->where('item_category_id', $category);
        }

        if (isset($price_range)) {
            $query->where('price', '<=', $price_range);
        }

        return $query->orderByDesc('created_at')->paginate(12)->withQueryString();
    }
}
