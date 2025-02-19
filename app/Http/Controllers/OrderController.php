<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Checkout Page
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1; 
        return view('template.checkout', compact('product', 'quantity'));
    }

    public function placeOrder(Request $request)
    {

         // Manually validate
    $validator = Validator::make($request->all(), [
        'full_name'      => 'required|string|max:255',
        'email'          => 'required|email|max:255',
        'phone'          => 'required|numeric',
        'address'        => 'required|string',
        'payment_method' => 'required|in:cod,paypal',
        'product_id'     => 'required|exists:products,id',
        'quantity'       => 'required|integer|min:1',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed!',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $product = Product::find($request->product_id);
    $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'product_id'     => $request->product_id,
            'product_name'   => $product->name,
            'full_name'      => $request->full_name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'quantity'       => $request->quantity,
            'total_price'    => $totalPrice, // Temporary fixed price to test
            'payment_method' => $request->payment_method,
            'status'         => 'pending',
        ]);
    
        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }    



}
