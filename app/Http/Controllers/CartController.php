<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    protected $middleware = ['auth'];

    private function getOrCreateCart()
    {
        $user = Auth::user();
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();
        $total = $cart->total();
        
        return view('cart.index', compact('items', 'total', 'cart'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $cart = $this->getOrCreateCart();

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock tidak tersedia.');
        }

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Stock tidak tersedia.');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Quantity updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();
        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
