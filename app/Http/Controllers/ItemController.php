<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category') ?? 1;

        $items = $this->buildCollectionFromSearch($category, $request->query('search'));
        $categories = ItemCategory::all();

        return Inertia::render('item/Index', [
            'items' => $items,
            'categories' => $categories,
            'filter' => [
                'category' => $category, 
                'search' => $request->query('search')
            ]
        ]);
    }

    private function buildCollectionFromSearch($category, $search) {
        $query = Item::with(['item_category']);
        
        if(isset($category) || isset($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            })
            ->where('item_category_id', $category);
        }
        
        return $query->orderByDesc('created_at')->paginate(10)->withQueryString();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ItemCategory::all();

        return Inertia::render('item/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = ItemCategory::all();

        return Inertia::render('item/Edit', [
            'categories' => $categories,
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
