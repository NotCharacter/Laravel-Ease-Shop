<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class LikeController extends Controller
{
    public function addLike(Request $request)
    {
        $productId = $request->id;
        $likes = session()->get('likes', []);

        if (!isset($likes[$productId])) {
            $product = Product::find($productId);
            if ($product) {
                $likes[$productId] = [
                    "name" => $product->name,
                    "image" => json_decode($product->images, true)[0] ?? 'products/default.jpg'
                ];
                session()->put('likes', $likes);
            }
        }

        return response()->json(['success' => true]);
    }

    public function removeLike(Request $request)
    {
        $likes = session()->get('likes', []);

        if (isset($likes[$request->id])) {
            unset($likes[$request->id]);
            session()->put('likes', $likes);
        }

        return response()->json(['success' => true]);
    }

    public function getLikeCount()
    {
        return response()->json(['count' => count(session()->get('likes', []))]);
    }

    public function showLikes()
    {
        return view('template.like');
    }
}
