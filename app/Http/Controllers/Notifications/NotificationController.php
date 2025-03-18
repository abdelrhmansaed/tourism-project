<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function Read($id)
    {
        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => '⚠️ يجب تسجيل الدخول لعرض الإشعارات.']);
        }

        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->delete();
            return redirect($notification->data['url'] ?? '/');
        }

        return redirect()->back()->withErrors(['error' => '🚫 الإشعار غير موجود.']);
    }

    /**
     * جعل جميع الإشعارات مقروءة عند الضغط على "قراءة الكل"
     */
    public function markAllAsRead()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => '⚠️ يجب تسجيل الدخول لعرض الإشعارات.']);
        }

        $user->unreadNotifications->delete();
        return redirect()->back();
    }

    /**
     * جلب المستخدم المسجل دخول سواء كان `admin` أو `provider`
     */
    private function getAuthenticatedUser()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        } elseif (Auth::guard('provider')->check()) {
            return Auth::guard('provider')->user();
        }
        elseif (Auth::guard('agent')->check()) {
            return Auth::guard('agent')->user();
        }
        return null; // إذا لم يكن المستخدم مسجل دخول
    }
}
