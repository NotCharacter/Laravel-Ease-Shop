@include('template.header')

<!-- Optional: Add animations -->
<style>
    .grid>div {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    .grid>div:nth-child(1) {
        animation-delay: 0.1s;
    }

    .grid>div:nth-child(2) {
        animation-delay: 0.2s;
    }

    .grid>div:nth-child(3) {
        animation-delay: 0.3s;
    }

    .grid>div:nth-child(4) {
        animation-delay: 0.4s;
    }

    .grid>div:nth-child(5) {
        animation-delay: 0.5s;
    }

    .grid>div:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


<!-- Hero Section -->
<div class="relative bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Summer Collection 2025</h1>
            <p class="text-lg mb-8">Discover the latest trends and exclusive deals</p>
        </div>
    </div>
</div>

<!-- Featured Categories with Slider -->
<div class="max-w-7xl mx-auto px-4 py-12 relative">
    <h2 class="text-2xl font-bold mb-8">Products by Category</h2>

    <!-- Slider Container -->
    <div class="relative">
        <!-- Previous Button -->
        <button onclick="slideCategories('prev')"
            class="absolute left-0 top-1/2 -translate-y-1/2 -ml-4 z-10 bg-white p-2 rounded-full shadow-lg hover:bg-indigo-600 hover:text-white transition-colors">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Slider Wrapper -->
        <div class="overflow-hidden">
            <div id="categoriesTrack" class="flex transition-transform duration-300 ease-in-out">
                @foreach ($products->unique('category') as $product)
                @php
                $images = json_decode($product->images, true);
                @endphp
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 flex-shrink-0 px-3">
                    <a href="{{ route('category.products', $product->category) }}">
                        <div class="relative rounded-lg overflow-hidden group h-64">
                            <img src="{{ asset('storage/' . ($images[0] ?? 'products/default.jpg')) }}"
                                alt="{{ $product->category }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                <span class="text-white text-xl font-bold">{{ $product->category }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Next Button -->
        <button onclick="slideCategories('next')"
            class="absolute right-0 top-1/2 -translate-y-1/2 -mr-4 z-10 bg-white p-2 rounded-full shadow-lg hover:bg-indigo-600 hover:text-white transition-colors">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
<!-- Products Section -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold">Latest Products</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
        @php
        $images = json_decode($product->images, true);
        @endphp
        <div class="bg-white rounded-lg shadow-lg overflow-hidden group">
            <div class="relative">
                <a href="{{route('products.show', $product->id) }}">
                    <img src="{{ asset('storage/' . ($images[0] ?? 'products/default.jpg')) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-64 object-cover cursor-pointer group-hover:scale-105 transition-transform duration-300">
                </a>
                <div class="absolute top-2 right-2 space-y-2">
                    <button class="like-btn bg-white p-2 rounded-full shadow-md hover:bg-indigo-600 hover:text-white transition"
                        data-id="{{ $product->id }}">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>

            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 60) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-sm text-gray-500 ml-2">(4.5)</span>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
    <!-- Pagination Links -->
    @if ($products->hasPages())
    <!-- Pagination Links -->
    <div class="mt-8 flex justify-center">
        <div class="pagination flex space-x-2">
            <!-- Previous Page -->
            @if ($products->onFirstPage())
            <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                &laquo; Prev
            </span>
            @else
            <a href="{{ $products->previousPageUrl() }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                &laquo; Prev
            </a>
            @endif

            <!-- Page Numbers -->
            @for ($i = 1; $i <= $products->lastPage(); $i++)
                <a href="{{ $products->url($i) }}"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-indigo-100 
                          {{ $i == $products->currentPage() ? 'bg-indigo-600 text-white' : '' }}">
                    {{ $i }}
                </a>
                @endfor

                <!-- Next Page -->
                @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Next &raquo;
                </a>
                @else
                <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                    Next &raquo;
                </span>
                @endif
        </div>
    </div>
    @endif

</div>


<!-- Store Features Grid Section -->
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Our Store</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover the unique features that make our store stand out from the competition.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Premium Quality -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Premium Quality</h3>
                <p class="text-gray-600">We carefully curate each product to ensure the highest quality standards. Every item in our collection is thoroughly tested and verified.</p>
            </div>

            <!-- Fast Shipping -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Fast Shipping</h3>
                <p class="text-gray-600">Enjoy free express shipping on orders over $50. We process all orders within 24 hours and provide real-time tracking information.</p>
            </div>

            <!-- Secure Payments -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Secure Payments</h3>
                <p class="text-gray-600">Shop with confidence using our secure payment system. We support multiple payment methods and ensure your data is protected.</p>
            </div>

            <!-- 24/7 Support -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                <p class="text-gray-600">Our dedicated customer service team is available round the clock to assist you with any questions or concerns you may have.</p>
            </div>

            <!-- Easy Returns -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Easy Returns</h3>
                <p class="text-gray-600">Not satisfied? Return any item within 30 days for a full refund. We make returns hassle-free with our prepaid shipping labels.</p>
            </div>

            <!-- Loyalty Rewards -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="mb-4 text-indigo-600">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Loyalty Rewards</h3>
                <p class="text-gray-600">Earn points with every purchase and unlock exclusive discounts. Join our loyalty program for special member-only benefits.</p>
            </div>
        </div>
    </div>
</section>




@include('template.footer')