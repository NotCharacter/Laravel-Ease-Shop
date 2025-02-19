<!-- resources/views/auth/orders/delivered_orders.blade.php -->

@include('auth.sidebar')

<main class="md:ml-64 p-8">
    <h2 class="text-2xl font-bold text-gray-800">Delivered Orders</h2>

    <!-- Delivered Orders List -->
    <div class="mt-6">
        @if($deliveredOrders->isEmpty())
            <p class="text-gray-500">No delivered orders available.</p>
        @else
            <div class="space-y-4">
                @foreach($deliveredOrders as $order)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800">Order #{{ $order->id }}</h3>
                        <p class="text-gray-600">Product: {{ $order->product->name }}</p>
                        <p class="text-gray-600">Quantity: {{ $order->quantity }}</p>
                        <p class="text-gray-600">Total Price: ${{ number_format($order->total_price, 2) }}</p>
                        <p class="text-gray-600">Status: 
                            <span class="text-green-500 font-semibold">{{ $order->status }}</span>
                        </p>
                        <p class="text-gray-600">Order placed by: {{ $order->full_name }}</p>
                        <p class="text-gray-600">Email: {{ $order->email }}</p>
                        <p class="text-gray-600">Phone: {{ $order->phone }}</p>
                        <p class="text-gray-600">Address: {{ $order->address }}</p>

                        <!-- Action Buttons (if needed) -->
                        <div class="mt-4 flex space-x-3">
                            <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

@include('auth.footer')
