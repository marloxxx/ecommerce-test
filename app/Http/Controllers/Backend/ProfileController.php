<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth()->user();
        return view('pages.backend.users.profile')->with('profile', $profile);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            return redirect()->back()->with('success', 'Successfully updated your profile');
        } else {
            return redirect()->back()->with('error', 'Please try again!');
        }
        return redirect()->back();
    }
}
