<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('pages.backend.coupon.index')->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'expiry_time' => 'required|date',
        ]);

        Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'status' => $request->status,
            'expiry_time' => $request->expiry_time,
        ]);

        return redirect()->route('backendcoupon.index')->with('success', 'Coupon created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('pages.backend.coupon.edit')->with('coupon', $coupon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive',
            'expiry_time' => 'required|date',
        ]);

        $coupon->update([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'status' => $request->status,
            'expiry_time' => $request->expiry_time,
        ]);

        return redirect()->route('backendcoupon.index')->with('success', 'Coupon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->delete()) {
            return redirect()->route('backendcoupon.index')->with('success', 'Coupon deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
