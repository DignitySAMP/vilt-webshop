<?php

namespace App\Http\Controllers;

use App\Models\UserCart;
use App\Models\UserCartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (! Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart = Auth::user()
            ->cart()
            ->with([
                'items',
                'items.item',
            ])
            ->first();

        if (! $cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json([
            'cart' => $cart,
        ]);
    }

    // TODO: except create, show, edit
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validate = $request->validate([
            'item' => 'required|exists:items,id',
        ]);

        $cart = Auth::user()->cart;
        if (! $cart) {
            $cart = UserCart::create([
                'user_id' => Auth::id(),
            ]);
        }
        // TODO: reduce cart items from stock
        // TODO: make this automatically expire after 48h, or if stock is already < X
        // TODO: make this show a status / label on the item

        // validate whether they already have this item in their cart, if not, make a new one
        $item = UserCartItem::firstWhere('item_id', $validate['item']);
        if ($item == null) {
            UserCartItem::create([
                'user_cart_id' => $cart->id,
                'item_id' => $validate['item'],
                'amount' => 1,
            ]);
        }
        // item is already in shopping card, increase the item amount...
        else {
            $item->amount++;
            $item->save();
        }

        $cart->load('items');

        return response()->json([
            'cart' => $cart,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserCart $userCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserCart $userCart)
    {
        //
    }
}
