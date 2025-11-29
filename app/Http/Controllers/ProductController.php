<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::with('category')->latest();

        // Search query
        if ($q = request('q')) {
            $query->where('name', 'like', "%{$q}%");
        }

        // Filter by category
        if ($cat = request('category')) {
            $query->where('category_id', $cat);
        }

        $products = $query->paginate(12)->withQueryString();

        // pass categories for filter dropdown
        $categories = \App\Models\Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used for public site. Admin manages products in admin area.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // handled by admin controller
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // admin only
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // admin only
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // admin only
    }
}
