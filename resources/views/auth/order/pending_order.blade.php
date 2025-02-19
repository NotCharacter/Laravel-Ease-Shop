@include('auth.sidebar')

<main class="md:ml-64 p-8">
    <h2 class="text-2xl font-bold text-gray-800">Pending Orders</h2>

    <!-- Pending Orders List -->
    <div class="mt-6">
        @if($pendingOrders->isEmpty())
            <p class="text-gray-500">No pending orders available.</p>
        @else
            <div class="space-y-4">
                @foreach($pendingOrders as $order)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-gray-800">Order #{{ $order->id }}</h3>
                        <p class="text-gray-600">Product: {{ $order->product->name }}</p>
                        <p class="text-gray-600">Quantity: {{ $order->quantity }}</p>
                        <p class="text-gray-600">Total Price: ${{ number_format($order->total_price, 2) }}</p>
                        <p class="text-gray-600">Status: 
                            <span class="text-yellow-500 font-semibold">{{ $order->status }}</span>
                        </p>
                        <p class="text-gray-600">Order placed by: {{ $order->full_name }}</p>
                        <p class="text-gray-600">Email: {{ $order->email }}</p>
                        <p class="text-gray-600">Phone: {{ $order->phone }}</p>
                        <p class="text-gray-600">Address: {{ $order->address }}</p>

                        <!-- Action Button to Mark Order as Delivered -->
                        @if($order->status == 'pending')
                            <div class="mt-4 flex space-x-3">
                                <button class="bg-green-500 text-white px-4 py-2 rounded-lg" onclick="markAsDelivered({{ $order->id }})">Mark as Delivered</button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

<script>
    // Ensure CSRF token is available for all AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Mark as Delivered
    function markAsDelivered(orderId) {
        if (confirm("Are you sure you want to mark this order as delivered?")) {
            // Perform the update request using AJAX
            fetch(`/orders/${orderId}/mark-delivered`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Use the CSRF token here
                },
                body: JSON.stringify({
                    status: 'delivered', // New status to update
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order status updated to delivered!');
                    location.reload();
                } else {
                    alert('There was an issue updating the order status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
        }
    }
</script>
