<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(Request $request)
{
    $admin = Auth::guard('admin')->user();
    $query = $admin->notifications()->orderBy('created_at', 'desc');
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }
    $notifications = $query->get();
    return view('admin.notifications.index', compact('notifications'));
}


    public function show($id)
    {
        $admin = Auth::guard('admin')->user();

        $notification = $admin->notifications()->findOrFail($id);

        if (!$notification->seen) {
            $notification->update(['seen' => true]);
        }

        return view('admin.notifications.show', compact('notification'));
    }

    public function markAllRead()
    {
        $admin = Auth::guard('admin')->user();

        $admin->notifications()->where('seen', false)->update(['seen' => true]);

        return redirect()->route('admin.notifications.index');
    }

    public function seen($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->update(['seen' => 1]);
    return redirect($notification->url);
}

}
