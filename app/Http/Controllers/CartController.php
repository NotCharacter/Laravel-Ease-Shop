<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
   

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        // Decode JSON images and select the first one
        $images = json_decode($product->images, true) ?? [];
        $imagePath = !empty($images) ? $images[0] : 'default.jpg';
    
        $cart = session()->get('cart', []);
    
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'image'    => $imagePath,
            ];
        }
    
        session()->put('cart', $cart);
    
        return response()->json(['success' => 'Product added to cart']);
    }
    
    


public function getCartCount()
{
    $cart = session()->get('cart', []);
    return response()->json(['cart_count' => count($cart)]);
}

public function updateCart(Request $request)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$request->id])) {
        $cart[$request->id]['quantity'] = $request->quantity;
        session()->put('cart', $cart);
    }

    return response()->json(['success' => true]);
}

public function removeFromCart(Request $request)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$request->id])) {
        unset($cart[$request->id]);
        session()->put('cart', $cart);
    }

    return response()->json(['success' => true]);
}
    
}