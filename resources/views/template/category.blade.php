@include('template.header')

<div class="max-w-7xl mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold mb-8">Category: {{ $category }}</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
            @php
                $images = json_decode($product->images, true);
            @endphp
            <div class="bg-white rounded-lg shadow-lg overflow-hidden group">
                <div class="relative">
                    <a href="{{ route('products.show', $product->id) }}">
                        <img src="{{ asset('storage/' . ($images[0] ?? 'products/default.jpg')) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-64 object-cover cursor-pointer group-hover:scale-105 transition-transform duration-300">
                    </a>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <span class="text-xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
</div>

@include('template.footer')
