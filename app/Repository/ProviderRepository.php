<?php

namespace App\Repository;

use App\Models\Admin;
use App\Models\Provider;
use App\Models\TripRequest;
use App\Notifications\TripAccepted;
use App\Notifications\TripApprovedPendingPayment;
use App\Notifications\TripRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderRepository implements ProviderRepositoryInterface
{
    public function index()
    {
        $providers = Provider::all();
        return view('Pages.Providers.index', compact('providers'));
    }

    public function create()
    {
        return view('Pages.Providers.add');
    }

    public function store(Request $request)
    {
        try {

            $providers = new Provider();
            $providers->name = $request->name;
            $providers->email = $request->email;
            $providers->password = bcrypt($request->password);
            $providers->age = $request->age;
            $providers->national_id = $request->national_id;
            $providers->save();
            toastr()->success(trans('تم اضافة مزود الخدمة بنجاح'));
            return redirect()->route('providers.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {

        $provider = Provider::findorfail($id);
        return view('pages.Providers.edit', compact('provider'));

    }

    public function update(array $data, Provider $provider)
    {
        // Validate incoming data
        // Validate incoming data
        $validatedData = validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $provider->id,
            'age' => 'nullable|integer|min:18',
            'national_id' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6', // Password is optional
        ])->validate();

        // If password is provided, hash and update it
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']); // Remove password if not provided
        }

        // Update agent data
        $provider->update($validatedData);

        return $provider;
    }

    public function destroy($request)
    {
        try {
            Provider::destroy($request->id);
            toastr()->error('تم حذف  مزود الخدمة بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function tripRequests()
    {
        $requests = TripRequest::where('status', 'pending')
            ->with(['trip', 'agent', 'detail']) // إضافة التفاصيل
            ->get();
        return view('Pages.providers.requests', compact('requests'));
    }

    public function approveRequestWaitingPayment($request_id)
    {
        try {
            $tripRequest = TripRequest::findOrFail($request_id);

            $tripRequest->update(['status' => 'waiting_payment']);

            // إرسال الإشعار إلى جميع الإدمن
            $admins = Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new TripApprovedPendingPayment($tripRequest));
            }

            toastr()->success('تم قبول الرحلة، وهي الآن في انتظار الدفع.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function approveRequest($request_id)
    {
        try {
            $provider = Auth::guard('provider')->user(); // ✅ جلب البروفايدر المسجل الدخول
            $tripRequest = TripRequest::findOrFail($request_id);

            // ✅ تحديث الحالة وتسجيل البروفايدر الذي قام بالموافقة
            $tripRequest->update([
                'status' => 'confirmed',
                'provider_id' => $provider->id, // ✅ يتم تعيين البروفايدر الحالي
            ]);
            // ✅ إرسال إشعار للمندوب بأن الرحلة قد تم تأكيدها
            if ($tripRequest->agent) {
                $tripRequest->agent->notify(new TripAccepted($tripRequest));
            }
            toastr()->success('تم قبول الرحلة، وتاكيدها بنجاح.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function rejectRequest($request_id)
    {
        try {
            $provider = Auth::guard('provider')->user(); // ✅ جلب البروفايدر المسجل الدخول
            $tripRequest = TripRequest::findOrFail($request_id);

            // ✅ تحديث الحالة وتسجيل البروفايدر الذي قام بالرفض
            $tripRequest->update([
                'status' => 'canceled',
                'provider_id' => $provider->id, // ✅ يتم تعيين البروفايدر الحالي
            ]);

            // إرسال إشعار للمندوب بأن الرحلة مرفوضة
            if ($tripRequest->agent) {
                $tripRequest->agent->notify(new TripRejected($tripRequest));
            }

            toastr()->error('تم رفض الرحلة بنجاح!');
            return redirect()->back();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function TripsWatingConfirm()
    {
        $requests = TripRequest::where('status', 'waiting_confirmation')
            ->with(['trip', 'agent', 'detail']) // إضافة التفاصيل
            ->get();
        return view('Pages.providers.watingconfirm', compact('requests'));


    }

    public function confirmedTrips()
    {
        $trips = TripRequest::where('status', 'confirmed ')
            ->with(['trip', 'agent', 'detail'])
            ->get();
        return view('Pages.Providers.confirmed_trips', compact('trips'));
    }

    public function rejectedTrips()
    {
        $trips = TripRequest::where('status', 'canceled')
            ->with(['trip', 'agent', 'detail'])
            ->get();
        return view('Pages.Providers.rejected_trips', compact('trips'));
    }
    public function showProfile($id)
    {
        $provider = Provider::findOrFail($id);

        // جلب جميع الرحلات التي عالجها البروفايدر
        $tripRequests = TripRequest::where('provider_id', $id) // تأكد من وجود هذا الحقل في جدول `trip_requests`
        ->with(['trip', 'detail'])
            ->get();

        return view('pages.Providers.profile', compact('provider', 'tripRequests'));
    }

}
