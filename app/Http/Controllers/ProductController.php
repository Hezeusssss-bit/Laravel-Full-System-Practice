<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sku' => 'required|string|unique:products,sku',
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'brand' => 'nullable|string|max:255',
                'unit' => 'required|string|max:50',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'current_stock' => 'required|integer|min:0',
                'minimum_stock_level' => 'required|integer|min:0',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|in:active,inactive',
                'description' => 'nullable|string',
            ]);

            $productData = $validated;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
                $productData['image'] = $imagePath;
            }

            $product = Product::create($productData);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'product' => $product
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the product'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'sku' => 'required|string|unique:products,sku,' . $id,
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'brand' => 'nullable|string|max:255',
                'unit' => 'required|string|max:50',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'current_stock' => 'required|integer|min:0',
                'minimum_stock_level' => 'required|integer|min:0',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|in:active,inactive',
                'description' => 'nullable|string',
            ]);

            $productData = $validated;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $imagePath = $request->file('image')->store('products', 'public');
                $productData['image'] = $imagePath;
            }

            $product->update($productData);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product'
            ], 500);
        }
    }

    public function getStats()
    {
        try {
            $totalProducts = Product::count();
            $activeProducts = Product::where('status', 'active')->count();
            $inactiveProducts = Product::where('status', 'inactive')->count();
            $lowStockProducts = Product::where('current_stock', '<=', \DB::raw('minimum_stock_level'))->count();
            $totalStockValue = Product::select(\DB::raw('SUM(current_stock * purchase_price) as value'))->first()->value ?? 0;

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_products' => $totalProducts,
                    'active_products' => $activeProducts,
                    'inactive_products' => $inactiveProducts,
                    'low_stock_products' => $lowStockProducts,
                    'total_stock_value' => $totalStockValue,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching stats'
            ], 500);
        }
    }
}
