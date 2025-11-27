<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:100',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes'       => 'nullable|string',
            'tags'        => 'nullable|string',
            'rating'      => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $validated['name'],
            'sku'         => $validated['sku'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'image'       => $imagePath,
            'sizes'       => $request->sizes,
            'tags'        => $request->tags,
            'rating'      => $request->rating,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan!']);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'sku'   => 'required|string|max:100',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $uploaded = $request->file('image')->store('products', 'public');
            $imagePath = $uploaded;
        }

        $product->update([
            'name'        => $validated['name'],
            'sku'         => $validated['sku'],
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'image'       => $imagePath,
            'sizes'       => $request->sizes ?? $product->sizes,
            'tags'        => $request->tags ?? $product->tags,
            'rating'      => $request->rating ?? $product->rating,
            'description' => $request->description ?? $product->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Produk berhasil diupdate!']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus!']);
    }

    public function showHomePage()
    {
        $all_db_products = Product::latest()->get();

        $products_for_js = $all_db_products->map(function ($product) {
            $image_url = $product->image 
                            ? '/storage/' . $product->image 
                            : 'https://via.placeholder.com/300'; 

            return [
                'id'          => $product->id,
                'name'        => $product->name,
                'sku'         => $product->sku,
                'price'       => $product->price,
                'stock'       => $product->stock,
                
                'image'       => $image_url,
                'gallery'     => [$image_url],
                
                'tags'        => $product->tags ? explode(',', $product->tags) : ['General'],
                'sizes'       => $product->sizes ? explode(',', $product->sizes) : ['All Size'],
                
                'rating'      => $product->rating ?? 4.5,
                'reviews'     => [],
                'description' => $product->description ?? 'Deskripsi produk belum tersedia.',
            ];
        });

        return view('home', [
        'products' => $all_db_products,       
        'products_for_js' => $products_for_js 
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product', compact('product'));
    }
}