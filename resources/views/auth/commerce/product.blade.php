@include('auth.sidebar')

<!-- Main Content -->
<main class="md:ml-64 p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Product</h2>
        </div>

        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                <input type="text" name="name" id="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Enter product name" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    placeholder="Enter product description" required></textarea>
            </div>

             <!-- Category Dropdown -->
             <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="Men">Men</option>
                    <option value="Women">Women</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Home & Kitchen">Home & Kitchen</option>
                </select>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Product Images (Max 5)</label>
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label for="images" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 2MB each)</p>
                            </div>
                            <input type="file" name="images[]" id="images" class="hidden" accept="image/*" multiple onchange="previewImages(event)">
                        </label>
                    </div>
                    <!-- Image Preview -->
                    <div id="imagePreviewContainer" class="grid grid-cols-3 gap-2 mt-2"></div>
                </div>
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="0" value="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                    required>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                    <input type="number" name="price" id="price" min="0" step="0.01"
                        class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="0.00" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</main>

@include('auth.footer')


<script>
document.addEventListener("DOMContentLoaded", function () {
    let selectedFiles = [];

    function updateFileInput() {
        const fileInput = document.getElementById('images');
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = ''; // Clear previous previews
        selectedFiles = [...files]; // Store files in an array

        if (selectedFiles.length > 5) {
            alert('You can upload a maximum of 5 images.');
            event.target.value = ''; // Reset file input
            selectedFiles = [];
            return;
        }

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('relative');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-24', 'h-24', 'object-cover', 'rounded-lg', 'shadow');

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '×';
                removeButton.classList.add('absolute', 'top-0', 'right-0', 'bg-red-600', 'text-white', 'rounded-full', 'px-2', 'py-1', 'text-xs');
                
                removeButton.onclick = function () {
                    selectedFiles.splice(index, 1); // Remove from array
                    imgContainer.remove();
                    updateFileInput();
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(removeButton);
                previewContainer.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });

        updateFileInput();
    }

    document.getElementById('images').addEventListener('change', previewImages);
});
</script>
