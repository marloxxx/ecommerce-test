<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Services\Tripay\TripayService;
use App\Services\Tripay\CallbackService;

class OrderController extends Controller
{
    private $tripayService;
    public function __construct()
    {
        $this->tripayService = new TripayService();
    }
    public function check(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid coupon code. Please try again.');
        }
        if ($coupon) {

            $total_price = Cart::totalCarts();
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);

            return redirect()->back()->with('success', 'Coupon has been applied.');
        }
    }

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->get();
        if ($cart->count() == 0) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'post_code' => 'required',
            'payment_method' => 'required',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->post_code = $request->post_code;
        $user->save();

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->order_number = uniqid('ORD-');
        $order->total_amount = Cart::totalCarts();
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'unpaid';
        $order->status = 'new';
        $order->save();

        $data = $request->all();
        $data['merchant_ref'] = 'INV-' . time();
        $data['customer_name'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
        $data['customer_email'] = auth()->user()->email;
        $data['customer_phone'] = auth()->user()->phone ?? '081234567890';
        foreach (Cart::where('user_id', auth()->id())->get() as $cart) {
            $data['order_items'][] = [
                'sku' => $cart->product->slug ?? 'SKU-1234567890',
                'name' => $cart->product->name ?? 'Product Name',
                'price' => $cart->product->price ?? 10000,
                'quantity' => $cart->quantity ?? 1,
            ];
        }
        $data['callback_url'] = route('transaction.callback');
        $data['return_url'] = route('order.invoice', $order->id);
        $data['expired_time'] = time() + (60 * 60); // 1 hour
        $data['amount'] = $order->total_amount;
        $data['method'] = $request->payment_method;
        try {
            $transaction = $this->tripayService->createTransaction($data);

            if (!$transaction->success) {
                return response()->json([
                    'status' => 'error',
                    'message' => $transaction->message,
                ]);
            }

            $transaction = $transaction->data;

            Payment::create([
                'user_id' => auth()->id(),
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'reference' => $transaction->reference,
                'status' => $transaction->status,
                'amount' => $transaction->amount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
        $carts = Cart::where('user_id', auth()->id())->get();
        foreach ($carts as $cart) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cart->product_id;
            $orderProduct->quantity = $cart->quantity;
            $orderProduct->price = $cart->product->price;
            $orderProduct->save();
        }

        // $carts = Cart::where('user_id', auth()->id())->delete();

        // check if coupon applied
        if (session()->has('coupon')) {
            $coupon = Coupon::findOrFail(session()->get('coupon')['id']);
            $coupon->used = $coupon->used + 1;
            $coupon->save();
        }

        // check if total order amount is greater than 2000000, then create coupon with value 10000 and expired in 3 month
        if ($order->total_amount >= 2000000) {
            $newCoupon = new Coupon();
            $newCoupon->code = uniqid('COUPON-');
            $newCoupon->type = 'fixed';
            $newCoupon->value = 10000;
            $newCoupon->expiry_date = now()->addMonth(3);
            $newCoupon->save();
        }

        // send new coupon to invoice
        session()->forget('coupon');
        session()->put('coupon', [
            'id' => $newCoupon->id,
            'code' => $newCoupon->code,
            'value' => $newCoupon->value
        ]);

        return redirect()->away($transaction->pay_url);
    }

    public function callback(Request $request)
    {
        $callbackService  = new CallbackService();
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $callbackService->handle($request->getContent(), $callbackSignature);

        return response()->json([
            'success' => true
        ]);
    }

    // PDF generate
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $order->load('orderProducts.product', 'user', 'coupon', 'payment');

        $coupon = null;
        // get coupon from session if exist
        if (session()->has('coupon')) {
            $coupon = Coupon::findOrFail(session()->get('coupon')['id']);
        }
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';

        // return $file_name;
        $pdf = Pdf::loadview('pages.frontend.cart.pdf', compact('order', 'coupon'));
        // show pdf in browser
        return $pdf->stream($file_name);
    }
}
