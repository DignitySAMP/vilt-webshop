<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->buildCollectionFromSearch($request->query('search'));

        return Inertia::render('item_category/Index', [
            'categories' => $categories,
            'filter' => [
                'search' => $request->query('search'),
            ],
        ]);
    }

    private function buildCollectionFromSearch($search)
    {
        $query = ItemCategory::select();

        if (isset($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->orderByDesc('created_at')->paginate(10)->withQueryString();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('item_category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:4|max:32|unique:item_categories,name',
            'description' => 'required|min:4|max:32',
        ]);

        ItemCategory::create([
            'name' => $validate['name'],
            'description' => $validate['description'],
        ]);

        return redirect()->route('category.index')->with('message', 'Category has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $category)
    {
        return Inertia::render('item_category/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $category)
    {
        $validate = $request->validate([
            'name' => [
                'required', 'min:4', 'max:32',
                Rule::unique('item_categories', 'name')->ignore($category->id), // check if name is unique, but ignore own id
            ],
            'description' => 'required|min:4|max:32',
        ]);

        $category->update([
            'name' => $validate['name'],
            'description' => $validate['description'],
        ]);

        return redirect()->route('category.index')->with('message', 'Category has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $category)
    {
        // TODO: add authorization (spatie roles?)
        $category->delete();

        return Inertia::location(route('category.index')); // TODO: sync flash message
    }
}
