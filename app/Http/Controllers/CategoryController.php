<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $categories = Category::with('products')->get();
        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $categoryData = $validated;
            $categoryData['slug'] = Str::slug($validated['name']);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
                $categoryData['image'] = $imagePath;
            }

            $category = Category::create($categoryData);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => $category
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
                'message' => 'An error occurred while creating the category'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::with('products')->findOrFail($id);
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'status' => 'required|in:active,inactive',
            ]);

            $categoryData = $validated;
            $categoryData['slug'] = Str::slug($validated['name']);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $imagePath = $request->file('image')->store('categories', 'public');
                $categoryData['image'] = $imagePath;
            }

            $category->update($categoryData);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'category' => $category
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
                'message' => 'An error occurred while updating the category'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            // Check if category has products
            if ($category->products()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category with existing products'
                ], 400);
            }

            // Delete image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the category'
            ], 500);
        }
    }

    public function getStats()
    {
        try {
            $totalCategories = Category::count();
            $activeCategories = Category::where('status', 'active')->count();
            $inactiveCategories = Category::where('status', 'inactive')->count();
            
            $categoriesWithProductCount = Category::withCount('products')->get();
            $totalProducts = $categoriesWithProductCount->sum('products_count');

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_categories' => $totalCategories,
                    'active_categories' => $activeCategories,
                    'inactive_categories' => $inactiveCategories,
                    'total_products' => $totalProducts,
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