@include('auth.sidebar')

<main class="md:ml-64 p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Product List</h2>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Images</th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Category</th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Price</th>
                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <!-- Product Images -->
                    <td class="p-3 flex space-x-2">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="h-12 w-12 object-cover rounded-lg shadow-md">
                        @endforeach
                    </td>

                    <!-- Product Name -->
                    <td class="p-3 text-gray-800">{{ $product->name }}</td>

                    <td class="p-3 text-gray-800">{{ $product->category }}</td>
                    <!-- Price -->
                    <td class="p-3 text-indigo-600 font-bold">${{ number_format($product->price, 2) }}</td>

                    <!-- Actions -->
                    <td class="p-3 flex space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('products.edit', $product->id) }}" 
                           class="px-3 py-1 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                            Edit
                        </a>

                        <!-- Delete Button -->
                        
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');"> @csrf @method('DELETE') <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600"> Delete </button> </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

@include('auth.footer')
