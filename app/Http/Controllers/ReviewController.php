<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product', 'user')->latest()->get();
        return view('pages.backend.review.index')->with('reviews', $reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $status = Review::create($request->except('_token'));
        if ($status) {
            return redirect()->route('review.index')->with('success', 'Review Successfully created');
        } else {
            return redirect()->route('review.index')->with('error', 'Something went wrong! Please try again!!');
        }

        return redirect()->route('review.index');
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if ($review) {

            $status = $review->update([
                'status' => $request->status
            ]);
            if ($status) {
                return redirect()->route('review.index')->with('success', 'Review Successfully updated');
            } else {
                return redirect()->route('review.index')->with('error', 'Something went wrong! Please try again!!');
            }
        } else {
            return redirect()->route('review.index')->with('error', 'Review not found!!');
        }

        return redirect()->route('review.index');
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if ($review) {
            $status = $review->delete();
            if ($status) {
                return redirect()->route('review.index')->with('success', 'Review Successfully deleted');
            } else {
                return redirect()->route('review.index')->with('error', 'Something went wrong! Please try again!!');
            }
        } else {
            return redirect()->route('review.index')->with('error', 'Review not found!!');
        }

        return redirect()->route('review.index');
    }
}
