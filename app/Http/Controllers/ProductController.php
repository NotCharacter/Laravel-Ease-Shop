<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Show all products on home page
    public function index()
    {
        $products = Product::latest()->paginate(12); // Fetch latest products (12 per page)
        return view('template.home', compact('products'));
    }
    
    // Show all products in admin view
    public function product_view()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->images = json_decode($product->images, true) ?? [];
        }
        return view('auth.commerce.view_product', compact('products'));
    }

    // Store a new product
public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'required|string',
        'category'    => 'required|string',
        'quantity'    => 'required|integer|min:0',
        'price'       => 'required|numeric|min:0',
        'images'      => 'nullable|array|max:5',
        'images.*'    => 'image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
        }
    }

    Product::create([
        'name'        => $request->name,
        'description' => $request->description,
        'category'    => $request->category, // ✅ Added category
        'quantity'    => $request->quantity,
        'price'       => $request->price,
        'images'      => json_encode($imagePaths),
    ]);

    return redirect()->route('products.view')->with('success', 'Product added successfully!');
}

public function show($id)
{
    $product = Product::findOrFail($id);
    return view('template.show', compact('product'));
}



    // Show edit product page
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $product->images = json_decode($product->images, true) ?? [];
        return view('auth.commerce.edit_product', compact('product'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string', 
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update product details
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->category    = $request->category; 
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;

        // Handle existing images
        $existingImages = $request->existing_images ?? [];
        $storedImages = json_decode($product->images, true) ?? [];

        // Remove deleted images
        foreach ($storedImages as $storedImage) {
            if (!in_array($storedImage, $existingImages)) {
                Storage::delete('public/' . $storedImage);
            }
        }

        // Handle new image uploads
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newImages[] = $image->store('products', 'public');
            }
        }

        // Merge existing and new images
        $product->images = json_encode(array_merge($existingImages, $newImages));
        $product->save();

        return redirect()->route('products.view')->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images
        if ($product->images) {
            foreach (json_decode($product->images, true) as $image) {
                Storage::delete('public/' . $image);
            }
        }

        $product->delete();

        return redirect()->route('products.view')->with('success', 'Product deleted successfully!');
    }


    public function search(Request $request)
{
    $query = $request->query('query');

    if (!$query) {
        return response()->json([]);
    }

    $products = Product::where('name', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%")
                        ->limit(5)
                        ->get();

    // Decode the image JSON and return the first image
    $products->transform(function ($product) {
        $images = json_decode($product->images, true) ?? [];
        $product->image = !empty($images) ? $images[0] : 'default.jpg';
        return $product;
    });

    return response()->json($products);
}


public function productsByCategory($category)
{
    $products = \App\Models\Product::where('category', $category)->paginate(12);
    return view('template.category', compact('products', 'category'));
}



// Likes Functions

public function likeProduct($id)
{
    $product = \App\Models\Product::find($id);
    
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $likes = session()->get('likes', []);

    if (isset($likes[$id])) {
        unset($likes[$id]); // Unlike if already liked
    } else {
        $likes[$id] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'image' => json_decode($product->images, true)[0] ?? 'default.jpg',
        ];
    }

    session()->put('likes', $likes);

    return response()->json(['success' => 'Updated like status', 'likes' => count($likes)]);
}

// Get liked products count for navbar
public function getLikes()
{
    return response()->json(['count' => count(session()->get('likes', []))]);
}


  public function rate(Request $request, $productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Validate the rating
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Calculate new average rating
        $newRating = $request->input('rating');
        $product->rating = $newRating; // Update rating to new value (you can average it over time)
        $product->save();

        return response()->json(['success' => true, 'rating' => $newRating]);
    }


}
