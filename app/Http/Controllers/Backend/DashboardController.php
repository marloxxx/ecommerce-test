<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $data = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }

        $activeCategory = Category::where('status', 'active')->count();
        $activeProduct = Product::where('status', 'active')->count();
        $activeOrder = Order::where('status', 'active')->count();

        return view('pages.backend.index')->with('users', $array)->with('activeCategory', $activeCategory)->with('activeProduct', $activeProduct)->with('activeOrder', $activeOrder);
    }

    public function settings()
    {
        $data = Setting::first();
        return view('pages.backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            'logo' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $data = $request->all();

        $settings = Setting::first();

        $status = $settings->fill($data)->save();
        if ($status) {
            return redirect()->back()->with('success', 'Setting successfully updated');
        } else {
            return redirect()->back()->with('error', 'Please try again');
        }
        return redirect()->route('backend.settings');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'Password successfully changed');
    }

    // Pie chart
    public function userPieChart(Request $request)
    {
        $data = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDay(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
        return view('backend.index')->with('course', json_encode($array));
    }
}
