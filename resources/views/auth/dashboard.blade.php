    @include('auth.sidebar')

    <!-- Main Content -->
    <main class="md:ml-64 p-8">
        <!-- Your main content here -->
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Content</h2>

        <!-- Orders Overview -->
<div class="p-6">
    <h2 class="text-2xl font-semibold text-gray-800">Orders Overview</h2>

    <div class="grid grid-cols-3 gap-6 mt-4">
        <!-- Pending Orders -->
        <div class="bg-yellow-100 p-5 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-yellow-800">Pending Orders</h3>
            <p class="text-4xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
        </div>

        <!-- Delivered Orders -->
        <div class="bg-green-100 p-5 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-green-800">Delivered Orders</h3>
            <p class="text-4xl font-bold text-green-600">{{ $deliveredOrders }}</p>
        </div>
    </div>
</div>


    </main>

    @include('auth.footer')
