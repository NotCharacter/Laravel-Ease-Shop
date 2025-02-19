@extends('template.header')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold text-gray-800">Checkout</h1>

    <div class="bg-white rounded-xl shadow-lg p-6 mt-4">
        <h2 class="text-lg font-semibold">Order Summary</h2>
        <p class="text-gray-600">{{ $product->name }} x {{ $quantity }}</p>
        <p class="text-gray-800 font-bold">Total: ${{ number_format($product->price * $quantity, 2) }}</p>

        <form action="{{ route('place.order') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">

            <div class="flex items-center space-x-4" x-data="{ quantity: 1 }">
    <span class="text-gray-700">Quantity:</span>
    <div class="flex items-center border border-gray-300 rounded-lg">
        <button 
            @click="quantity = Math.max(1, quantity - 1)" 
            type="button"
            class="px-3 py-2 border-r border-gray-300 hover:bg-gray-100 transition">
            <i class="fas fa-minus text-gray-600"></i>
        </button>
        <input type="hidden" name="quantity" :value="quantity">
        <span class="px-4 py-2" x-text="quantity"></span>
        <button 
            @click="quantity = Math.min(99, quantity + 1)"
            type="button"
            class="px-3 py-2 border-l border-gray-300 hover:bg-gray-100 transition">
            <i class="fas fa-plus text-gray-600"></i>
        </button>
    </div>
    <div class="text-gray-700">
        Total: <span class="font-bold text-indigo-600" x-text="'$' + (quantity * {{ $product->price }}).toFixed(2)"></span>
    </div>
</div>

            <label class="block text-gray-700 font-medium mt-2">Full Name</label>
            <input type="text" name="full_name" class="w-full px-4 py-2 border rounded-lg" required>

            <label class="block text-gray-700 font-medium mt-2">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg" required>

            <label class="block text-gray-700 font-medium mt-2">Phone</label>
            <input type="number" name="phone" class="w-full px-4 py-2 border rounded-lg" required>

            <label class="block text-gray-700 font-medium mt-2">Address</label>
            <textarea name="address" class="w-full px-4 py-2 border rounded-lg" required></textarea>

            <label class="block text-gray-700 font-medium mt-2">Payment Method</label>
            <select name="payment_method" class="w-full px-4 py-2 border rounded-lg">
                <option value="cod">Cash on Delivery</option>
                <option value="paypal">PayPal</option>
            </select>

            <button type="submit" class="mt-4 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                Place Order
            </button>
        </form>
    </div>
</div>



@include('template.footer')
