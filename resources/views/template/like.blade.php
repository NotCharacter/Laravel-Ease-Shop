@include('template.header')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold mb-4">Your Liked Products</h1>

    @if(session('likes') && count(session('likes')) > 0)
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-4">Product</th>
                    <th class="p-4">Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('likes') as $id => $item)
                    <tr class="border-t">
                        <td class="p-4 flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 rounded-lg">
                            <span>{{ $item['name'] }}</span>
                        </td>
                        <td class="p-4">
                            <button onclick="removeFromLikes({{ $id }})" class="text-red-500">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">You haven't liked any products yet.</p>
    @endif
</div>

@include('template.footer')
