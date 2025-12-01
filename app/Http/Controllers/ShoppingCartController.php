<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class ShoppingCartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $uuid = $this->getCartUuid($request);
        $cart = $this->getOrCreateCart($uuid);

        $cart->load(['items.item']);

        return response()->json([
            'cart' => $cart,
            'items' => $cart->items,
            'total' => $cart->items->sum(fn ($item) => $item->quantity * $item->item->price),
            'total_items' => $cart->items->sum('quantity'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item' => 'required|exists:items,id',
            'quantity' => 'sometimes|integer|min:1|max:99',
        ]);

        $uuid = $this->getCartUuid($request);
        $cart = $this->getOrCreateCart($uuid);

        $cartItem = $cart->items()->where('item_id', $validated['item'])->first();

        if ($cartItem) {
            // Update existing item
            $cartItem->increment('quantity', $validated['quantity'] ?? 1);
        } else {
            // Create new item
            $cartItem = $cart->items()->create([
                'item_id' => $validated['item'],
                'quantity' => $validated['quantity'] ?? 1,
            ]);
        }

        $cart->load(['items.item']);

        return response()->json([
            'message' => 'Item added to cart',
            'cart' => $cart,
            'items' => $cart->items,
            'total' => $cart->items->sum(fn ($item) => $item->quantity * $item->item->price),
            'total_items' => $cart->items->sum('quantity'),
        ], 201);
    }

    public function update(Request $request, ShoppingCart $cart): JsonResponse
    {
        $validated = $request->validate([
            'item' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $uuid = $this->getCartUuid($request);

        // does cart belong to uuid?
        if ($cart->uuid !== $uuid) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // fetch item collection
        $cartItem = ShoppingCartItem::where('item_id', $validated['item'])->where('shopping_cart_id', $cart->id)->firstOrFail();

        // remove item if quantity is below 1
        if ($validated['quantity'] < 1) {
            $cartItem->delete();
            $message = 'Item removed from cart';
        } else {
            // update quantity
            $cartItem->update([
                'quantity' => $validated['quantity'],
            ]);
            $message = 'Item quantity updated';
            $cartItem->save();
        }

        // check if cart is empty, fallback after deleting an item
        if ($cart->items()->count() === 0) {
            $cart->delete();

            return response()->json([
                'message' => 'Cart is now empty',
                'cart' => null,
                'items' => [],
                'total' => 0,
                'total_items' => 0,
            ]);
        }

        // preload the items in the cart so we can return it
        $cart->load(['items.item']);

        return response()->json([
            'message' => $message,
            'cart' => $cart,
            'items' => $cart->items,
            'total' => $cart->items->sum(fn ($item) => $item->quantity * $item->item->price),
            'total_items' => $cart->items->sum('quantity'),
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $uuid = $this->getCartUuid($request);
        $cart = ShoppingCart::where('uuid', $uuid)->first();

        if ($cart) {
            $cart->delete();
        }

        return response()->json([
            'message' => 'Cart cleared',
            'cart' => null,
            'items' => [],
            'total' => 0,
            'total_items' => 0,
        ]);
    }

    private function getCartUuid(Request $request): string
    {
        if (Auth::check()) {
            return Auth::user()->getCartUuid();
        }

        $cookieUuid = $request->cookie('cart_uuid');

        if (! $cookieUuid) {
            $cookieUuid = (string) Str::uuid();
            Cookie::queue('cart_uuid', $cookieUuid, 60 * 24 * 21); // 21 days
        }

        return $cookieUuid;
    }

    private function getOrCreateCart(string $uuid): ShoppingCart
    {
        return ShoppingCart::firstOrCreate(
            ['uuid' => $uuid],
            ['uuid' => $uuid]
        );
    }
}
