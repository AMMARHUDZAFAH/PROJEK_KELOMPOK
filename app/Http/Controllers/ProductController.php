<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('category')->latest();

        if ($q = request('q')) {
            $query->where('name', 'like', "%{$q}%");
        }

        if ($cat = request('category')) {
            $query->where('category_id', $cat);
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = \App\Models\Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
    }

    public function update(Request $request, Product $product)
    {
    }

    public function destroy(Product $product)
    {
    }
}
