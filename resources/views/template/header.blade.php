<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ShopEase - Your Premium Shopping Destination</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Top Banner -->
    <div class="bg-indigo-600 text-white text-sm py-2">
        <div class="max-w-7xl mx-auto px-4 text-center">
            🚚 Free shipping on orders over $50! Limited time offer
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden flex items-center text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Logo -->
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">ShopEase</span>
                </div>

                <!-- Desktop Search Bar -->
                <form onsubmit='return false' class="hidden md:flex flex-1 max-w-2xl mx-6">
                    <div class="relative w-full">
                        <input type="text" 
                               id='searchInput'
                               placeholder="Search for products..." 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               onkeyup="searchProducts('searchInput', 'searchResults')">
                        <button class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600">
                            <i class="fas fa-search"></i>
                        </button>
                        <div id="searchResults" class="absolute bg-white border border-gray-300 w-80 mt-1 rounded-lg shadow-lg hidden"></div>
                    </div>
                </form>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-6">
                   <!-- Like/Wishlist -->
                    <a href="{{ route('products.likes') }}" class="relative text-gray-700 hover:text-indigo-600">
                        <i class="fas fa-heart text-xl"></i>
                        <span id="likes-count" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                            {{ count(session()->get('likes', [])) }}
                        </span>
                    </a>

                    <!-- Cart -->
                    <div class="relative" x-data="{ cartOpen: false, cartCount: 0 }" x-init="fetchCartCount()">
                        <a href="{{ route('cart.view') }}" class="text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span x-show="cartCount > 0" 
                                  class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">
                                <span x-text="cartCount"></span>
                            </span>
                        </a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Register
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="md:hidden border-t border-gray-200">
                
                <!-- Mobile Search -->
                <div class="py-4">
                    <form onsubmit='return false'>
                        <div class="relative">
                            <input type="text" 
                                   id='mobileSearchInput'
                                   placeholder="Search for products..." 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   onkeyup="searchProducts('mobileSearchInput', 'mobileSearchResults')">
                            <button class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600">
                                <i class="fas fa-search"></i>
                            </button>
                            <div id="mobileSearchResults" class="absolute bg-white border border-gray-300 w-full mt-1 rounded-lg shadow-lg hidden"></div>
                        </div>
                    </form>
                </div>

                <!-- Mobile Auth -->
                <div class="md:hidden py-4 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="block py-2 text-gray-700 hover:text-indigo-600">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block py-2 text-gray-700 hover:text-indigo-600">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </header>
    <script>
        function fetchCartCount() {
            fetch("{{ route('cart.count') }}")
                .then(response => response.json())
                .then(data => {
                    document.querySelector('[x-data]').__x.$data.cartCount = data.cart_count;
                });
        }

        function addToCart(productId, productName, productPrice, productImage) {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage
                })
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('[x-data]').__x.$data.cartCount = data.cart_count;
            });
        }

        // Updated search function for handling both desktop and mobile
        function searchProducts(inputId, resultsId) {
            let query = document.getElementById(inputId).value;

            // Check if query is valid and greater than 2 characters
            if (query.length < 2) {
                document.getElementById(resultsId).classList.add("hidden");
                return;
            }

            fetch("{{ route('search') }}?query=" + query)
                .then(response => response.json())
                .then(data => {
                    let resultsDiv = document.getElementById(resultsId);
                    resultsDiv.innerHTML = ""; // Clear previous results

                    if (data.length === 0) {
                        resultsDiv.innerHTML = "<p class='p-2 text-gray-500'>No products found.</p>";
                    } else {
                        data.forEach(product => {
                            let item = `
                                <a href="/products/${product.id}" class="block p-2 border-b hover:bg-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <img src="/storage/${product.image}" class="w-12 h-12 object-cover rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium">${product.name}</p>
                                            <p class="text-xs text-gray-500">$${product.price}</p>
                                        </div>
                                    </div>
                                </a>
                            `;
                            resultsDiv.innerHTML += item;
                        });
                    }

                    resultsDiv.classList.remove("hidden"); // Show results div
                })
                .catch(error => console.error("Search error:", error));
        }
    </script>
