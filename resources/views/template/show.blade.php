@include('template.header')

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ currentImage: 0 }">

        <!-- Product Image Section -->
        <div class="relative">
            @php
            $images = json_decode($product->images, true) ?? [];
            @endphp

            <div class="relative overflow-hidden border border-gray-200 rounded-lg group">
                @foreach ($images as $index => $image)
                <img src="{{ asset('storage/' . $image) }}"
                    alt="{{ $product->name }}"
                    class="w-full max-h-[500px] object-contain transition-opacity duration-500"
                    :class="{ 'opacity-0': currentImage !== {{ $index }} }"
                    x-show="currentImage === {{ $index }}"
                    loading="lazy">
                @endforeach

                <!-- Previous & Next Buttons -->
                @if(count($images) > 1)
                <button @click="currentImage = (currentImage - 1 + {{ count($images) }}) % {{ count($images) }}"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white p-3 rounded-full shadow hover:bg-gray-200 transition">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button @click="currentImage = (currentImage + 1) % {{ count($images) }}"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white p-3 rounded-full shadow hover:bg-gray-200 transition">
                    <i class="fas fa-chevron-right"></i>
                </button>
                @endif
            </div>

            <!-- Thumbnail Images -->
            @if(count($images) > 1)
            <div class="flex justify-center space-x-2 mt-3">
                @foreach ($images as $index => $image)
                <img src="{{ asset('storage/' . $image) }}"
                    class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-indigo-600"
                    @click="currentImage = {{ $index }}">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="space-y-4">
            <h1 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h1>
            <p class="text-gray-600">{{ $product->description }}</p>

            <!-- Price Section -->
            <div class="flex items-center space-x-2">
                <span class="text-3xl font-bold text-indigo-600">Price: ${{ number_format($product->price, 2) }}</span>
                @if($product->compare_price)
                <span class="text-lg text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                @endif
            </div>

            <!-- Ratings -->
            <div class="flex items-center space-x-1 text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <=floor($product->rating))
                    <i class="fas fa-star"></i>
                    @elseif ($i - 0.5 <= $product->rating)
                        <i class="fas fa-star-half-alt"></i>
                        @else
                        <i class="far fa-star"></i>
                        @endif
                        @endfor
                        <span class="text-sm text-gray-500">({{ number_format($product->rating, 1) }})</span>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button onclick="addToCart({{ $product->id }})"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition flex items-center space-x-2">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Add to Cart</span>
                </button>

                <a href="{{ route('checkout', ['product_id' => $product->id, 'quantity' => 1]) }}"
                    class="bg-red-500 text-white px-6 py-3 rounded-lg shadow hover:bg-red-600 transition flex items-center space-x-2">
                    <i class="fas fa-bolt"></i>
                    <span>Check Out</span>
                </a>
            </div>
        </div>
    </div>
</div>

@include('template.footer')