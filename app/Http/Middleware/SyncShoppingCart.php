<?php

namespace App\Http\Middleware;

use App\Models\ShoppingCart;
use Closure;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SyncShoppingCart
{
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = $request->cookie('cart_uuid');
        $user = Auth::user();

        // no guest cart -> continue
        if (!$uuid) {
            return $next($request);
        }

        // load guest cart with items
        $guestCart = ShoppingCart::with('items')->where('uuid', $uuid)->first();
        if (!$guestCart) { // no cart, continue
            return $next($request);
        }

        // user is not logged in -> nothing to sync
        if (!$user) {
            return $next($request);
        }

        // user cart is SAME as guest cart -> dont sync
        if ($guestCart->uuid === $user->getCartUuid()) {
            Cookie::expire('cart_uuid'); // reset old guest cart
            return $next($request);
        }

        // load user’s saved cart with items
        $userCart = ShoppingCart::with('items')->where('uuid', $user->getCartUuid())->first();

        // merge guest cart into user cart
        if ($userCart) {
            $userCart->mergeItemsFrom($guestCart);
            Cookie::expire('cart_uuid'); // reset old guest cart
        }

        return $next($request);
    }
}
