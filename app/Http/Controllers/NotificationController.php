<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('pages.backend.notification.index');
    }

    public function show(Request $request)
    {
        $notification = Auth::user()->notifications->where('id', $request->id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }
    public function delete($id)
    {
        $notification = Auth::user()->notifications->where('id', $id)->first();
        if ($notification) {
            $status = $notification->delete();
            if ($status) {
                return redirect()->back()->with('success', 'Notification successfully deleted');
            } else {
                return back()->with('error', 'Error please try again');
            }
        } else {
            return back()->with('error', 'Notification not found');
        }
    }
}
