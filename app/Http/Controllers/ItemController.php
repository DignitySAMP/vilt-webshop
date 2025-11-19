<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'search' => $request->query('search'),
            ],
        ]);
    }

    private function buildCollectionFromSearch($category, $search)
    {
        $query = Item::with(['item_category', 'supplier']);

        if (isset($category) || isset($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
                ->where('item_category_id', $category);
        }

        return $query->orderByDesc('created_at')->paginate(10)->withQueryString();
    }

    /**
     * Show the specific resource.
     */
    public function show(Item $item)
    {
        $item->load(['item_category', 'supplier']);

        return Inertia::render('item/Show', [
            'item' => $item,
            'similar' => $item->similar(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('item/Create', [
            'categories' => ItemCategory::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:64',
            'category' => 'required|exists:item_categories,id',
            'supplier' => 'required|exists:suppliers,id',
            'description' => 'required|min:8',
            'image' => 'required|file|image|max:1500',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $item_category = ItemCategory::findOrFail($validate['category']);
        $supplier = Supplier::findOrFail($validate['supplier']);

        $item = Item::create([
            'name' => $validate['name'],
            'item_category_id' => $item_category->id,
            'image' => 'placeholder.png',
            'supplier_id' => $supplier->id,
            'description' => $validate['description'],
            'price' => $validate['price'],
            'stock' => $validate['stock'],
        ]);

        $extension = $request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->storeAs(
            path: 'items/'.$item->id,
            name: 'image.'.$extension,
            options: 'public'
        );

        $item->update(['image' => $imagePath]);

        return redirect()->route('item.index')->with('message', 'Item has been successfully created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return Inertia::render('item/Edit', [
            'categories' => ItemCategory::all(),
            'suppliers' => Supplier::all(),
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validate = $request->validate([
            'name' => 'required|max:64',
            'category' => 'required|exists:item_categories,id',
            'supplier' => 'required|exists:suppliers,id',
            'description' => 'required|min:8',
            'image' => 'nullable|file|image|max:1500',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $item_category = ItemCategory::findOrFail($validate['category']);
        $supplier = Supplier::findOrFail($validate['supplier']);

        $imagePath = $item->image_url; // store original image
        if ($request->hasFile('image')) { // replace image only if new image got passed
            $extension = $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs(
                path: 'items/'.$item->id,
                name: 'image.'.$extension,
                options: 'public'
            );
        }

        $item->update([
            'name' => $validate['name'],
            'item_category_id' => $item_category->id,
            'image' => $imagePath,
            'supplier_id' => $supplier->id,
            'description' => $validate['description'],
            'price' => $validate['price'],
            'stock' => $validate['stock'],
        ]);

        return redirect()->route('item.index')->with('message', 'Item has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // TODO: add authorization (spatie roles?)
        $item->delete();

        return Inertia::location(route('item.index')); // TODO: sync flash message
    }
}
