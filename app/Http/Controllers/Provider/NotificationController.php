<?php
namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $provider = Auth::guard('provider')->user();

        $query = $provider->notifications()->orderBy('created_at', 'desc');

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $notifications = $query->get();

        return view('provider.notifications.index', compact('notifications'));
    }


    public function markAllRead()
    {
        // $providerId = Auth::guard('provider')->id();

        $notifications = Auth::guard('provider')->user()->notifications()->update([
            "seen" => 1
        ]);

        return redirect()->back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }
    public function seen($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->update(['seen' => 1]);
    return redirect($notification->url);
}

}
