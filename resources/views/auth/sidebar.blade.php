<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Mobile Menu Button -->
    <button id="mobile-menu-button" class="md:hidden fixed top-4 left-4 z-50 bg-indigo-600 text-white p-2 rounded-lg">
        <i class="fas fa-bars"></i>
    </button>

    <aside id="sidebar" class="fixed hidden md:block w-64 h-screen bg-gradient-to-b from-indigo-900 to-indigo-700 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Profile Section -->
    <div class="p-5 border-b border-indigo-800">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center">
                <i class="fas fa-user text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Welcome</h2>
                <p class="text-sm text-indigo-200">{{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-2">
        <!-- Products Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between py-2 px-4 hover:bg-indigo-600 rounded-lg transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-home"></i>
                    <span>Products</span>
                </div>
                <i class="fas fa-chevron-down text-sm"></i>
            </button>
            <div x-show="open" x-transition class="pl-8 mt-2 space-y-2">
                <a href="{{ route('product') }}" class="block py-2 px-4 hover:bg-indigo-600 rounded-lg text-indigo-200 hover:text-white transition-colors duration-200">Add Product</a>
                <a href="{{ route('products.view') }}" class="block py-2 px-4 hover:bg-indigo-600 rounded-lg text-indigo-200 hover:text-white transition-colors duration-200">View Product</a>
            </div>
        </div>

        <!-- Orders Dropdown -->
        <div x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-between py-2 px-4 hover:bg-indigo-600 rounded-lg transition-colors duration-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user-circle"></i>
                    <span>Orders</span>
                </div>
                <i class="fas fa-chevron-down text-sm"></i>
            </button>
            <div x-show="open" x-transition class="pl-8 mt-2 space-y-2">
                <a href="{{ route('pending.orders') }}" class="block py-2 px-4 hover:bg-indigo-600 rounded-lg text-indigo-200 hover:text-white transition-colors duration-200">Pending Order</a>
                <a href="{{ route('delivered.orders') }}" class="block py-2 px-4 hover:bg-indigo-600 rounded-lg text-indigo-200 hover:text-white transition-colors duration-200">Delivered Order</a>
            </div>
        </div>

        <!-- Logout Link -->
        <a href="{{ route('logout') }}" class="flex items-center space-x-3 py-2 px-4 hover:bg-indigo-600 rounded-lg transition-colors duration-200">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </nav>
</aside>

