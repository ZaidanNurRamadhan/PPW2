<?php
// app/Http/Controllers/Api/ProductApiController.php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    // GET all products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // POST create a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // GET a specific product
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    // PUT update a product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($request->only(['name', 'price', 'description']));
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    // DELETE a product
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted'], 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }
}
