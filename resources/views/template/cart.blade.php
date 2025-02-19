@include('template.header')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-4">Product</th>
                    <th class="p-4">Price</th>
                    <th class="p-4">Quantity</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Remove</th>
                </tr>
            </thead>
            <tbody>
            @foreach(session('cart') as $id => $item)
    <tr class="border-t">
        <td class="p-4 flex items-center space-x-4">
            <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 rounded-lg">
            <span>{{ $item['name'] }}</span>
        </td>
        <td class="p-4">${{ number_format($item['price'], 2) }}</td>
        <td class="p-4">
           <p>{{ $item['quantity'] }}</p>
        </td>
        <td class="p-4">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
        <td class="p-4">
            <button onclick="removeFromCart({{ $id }})" class="text-red-500">
                <i class="fas fa-trash"></i>
            </button>   
        </td>
    </tr>
@endforeach

            </tbody>
        </table>

    @else
        <p class="text-gray-600">Your cart is empty.</p>
    @endif
</div>

@include('template.footer')
