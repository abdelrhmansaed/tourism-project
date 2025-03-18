<?php

namespace App\Http\Controllers\Requestes;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\TripRequest;
use App\Models\TripRequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripRequestController extends Controller
{
    public function providerApprovedTrips()
    {
        $trips = TripRequest::where('status', 'waiting_payment')
            ->with(['trip', 'agent', 'detail']) // إضافة التفاصيل
            ->get();

        return view('Pages.Requestes.provider_approved', compact('trips'));
    }

    public function uploadPaymentProof(Request $request, $trip_id)
    {


        try {
            $request->validate([
                'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // البحث عن تفاصيل الرحلة
            $tripDetail = TripRequestDetail::where('trip_request_id', $trip_id)->first();
            $trip = TripRequest::find($trip_id);
            if (!$tripDetail) {
                return back()->withErrors(['error' => 'لم يتم العثور على تفاصيل الرحلة.']);
            }

            // حفظ الصورة داخل مجلد `storage/app/public/payment_proofs`
            $imagePath = $request->file('payment_proof')->store('payment_proofs', 'public');

            // تحديث سجل الرحلة وإضافة الصورة
            $tripDetail->update([
                'image' => $imagePath,
            ]);
            // تحديث بيانات الرحلة بالحالة الجديدة ومسار الصورة
            $trip->update([
                'status' => 'waiting_confirmation', // بانتظار موافقة البروفايدر
            ]);

            toastr()->success('تم رفع إثبات الدفع بنجاح، بانتظار موافقة مزود الخدمة.');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showTripDetails($trip_id)
    {
        // جلب بيانات الرحلة مع العلاقات المطلوبة
        $trip = TripRequest::with(['trip', 'agent', 'detail'])->findOrFail($trip_id);

        return view('Pages.Trips.details', compact('trip'));
    }

    public function tripRequests()
    {
        $requests = TripRequest::where('status', 'pending')
            ->with(['trip', 'agent', 'detail']) // إضافة التفاصيل
            ->get();
        return view('Pages.Requestes.requests',compact('requests'));
    }

}
