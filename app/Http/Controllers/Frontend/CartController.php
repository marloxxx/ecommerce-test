<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Tripay\TripayService;

class CartController extends Controller
{
    private $tripayService;
    public function __construct()
    {
        $this->tripayService = new TripayService();
    }
    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();
        return view('pages.frontend.cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->first();
        } else {
            return response()->json(['error' => true, 'message' => 'At first login your account !!']);
        }

        if (!is_null($cart)) {
            $cart->increment('quantity');
        } else {
            $cart = new Cart();
            if (auth()->check()) {
                $cart->user_id = auth()->id();
            }
            $cart->product_id = $request->product_id;
            $cart->save();
        }

        return response()->json(['success' => true, 'message' => 'Item added to cart successfully !!']);
    }

    public function decrease(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
        return response()->json(['success' => true, 'message' => 'Item quantity decreased successfully !!']);
    }

    public function increase(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        $cart->increment('quantity');
        return response()->json(['success' => true, 'message' => 'Item quantity increased successfully !!']);
    }

    public function destroy(Request $request)
    {
        $cart = Cart::findOrFail($request->cart_id);
        if (!is_null($cart)) {
            $cart->delete();
        } else {
            return response()->json(['error' => true, 'message' => 'Cart not found !!']);
        }
        return response()->json(['success' => true, 'message' => 'Cart deleted successfully !!']);
    }

    public function checkout()
    {
        $channels = $this->tripayService->getPaymentChannels();
        if (!$channels->success) {
            return redirect()->route('profile.index')->with('error', $channels->message);
        }
        $channels = $channels->data;
        return view('pages.frontend.cart.checkout', compact('channels'));
    }
}
