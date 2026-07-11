<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
   public function index(Request $request)
{
    $customer = Auth::guard('customer')->user();
    $query = $customer->notifications()->orderBy('created_at', 'desc');
    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }
    $notifications = $query->get();
    return view('customer.notifications.index', compact('notifications'));
}


    public function show($id)
    {
        $customer = Auth::guard('customer')->user();

        $notification = $customer->notifications()->findOrFail($id);

        if (!$notification->seen) {
            $notification->update(['seen' => true]);
        }

        return view('customer.notifications.show', compact('notification'));
    }

    public function markAllRead()
    {
        $customer = Auth::guard('customer')->user();

        $customer->notifications()->where('seen', false)->update(['seen' => true]);

        return redirect()->route('customer.notifications.index');
    }

    public function seen($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->update(['seen' => 1]);
    return redirect($notification->url);
}

}
