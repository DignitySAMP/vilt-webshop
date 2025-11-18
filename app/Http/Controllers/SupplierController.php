<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = $this->buildCollectionFromSearch($request->query('search'));

        return Inertia::render('supplier/Index', [
            'suppliers' => $suppliers,
            'filter' => [
                'search' => $request->query('search'),
            ],
        ]);
    }

    private function buildCollectionFromSearch($search)
    {
        $query = Supplier::select();

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Supplier $supplier)
    {
        // sort order based on query
        $orderSortDate = $request->input('order_sort_date', 'by_newest_create');
        $supplier->load(['orders' => function ($query) use ($orderSortDate) {
            switch ($orderSortDate) {
                case 'by_oldest_create':
                    $query->oldest('created_at');
                    break;

                case 'by_newest_create':
                    $query->latest('created_at');
                    break;

                case 'by_oldest_update':
                    $query->oldest('updated_at');
                    break;

                case 'by_newest_update':
                    $query->latest('updated_at');
                    break;

                case 'no_updates': // orders where updated_at equals created_at (never updated)
                    $query->whereColumn('updated_at', '=', 'created_at')
                        ->latest('created_at');
                    break;

                case 'oldest_update': // orders that have been updated, sorted by oldest update
                    $query->whereColumn('updated_at', '!=', 'created_at')
                        ->oldest('updated_at');
                    break;

                case 'newest_update': // orders that have been updated, sorted by newest update
                    $query->whereColumn('updated_at', '!=', 'created_at')
                        ->latest('updated_at');
                    break;

                default:
                    $query->latest('created_at');
                    break;
            }

            $query->limit(10);
        }]);

        return Inertia::render('supplier/Show', [
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->name,
                'description' => $supplier->description,
                'updated_at' => $supplier->updated_at,
                'created_at' => $supplier->created_at,
                'contacts' => $supplier->contacts,
                'addresses' => $supplier->addresses,
                'orders' => $supplier->orders,
            ],
            'filters' => [
                'order_sort_date' => $orderSortDate,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
