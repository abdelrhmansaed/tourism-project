<?php

namespace App\Repository;

use App\Http\Requests\AgentRequest;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\Provider;
use App\Models\Trip;
use App\Models\TripRequest;
use App\Models\TripRequestDetail;
use App\Notifications\TripRequested;
use App\Repository\AgentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentRepository implements AgentRepositoryInterface
{
    public function index()
    {
        $agents = Agent::all();
        return view('Pages.Agents.index',compact('agents')) ;
    }
    public function create()
    {
        return view('Pages.Agents.add') ;
    }
    public function store(AgentRequest $request )
    {
        try {

            $agent = new Agent();
            $agent ->name  =$request->name;
            $agent ->email  =$request->email;
            $agent ->password  = bcrypt($request->password);
            $agent ->age  =$request->age;
            $agent ->national_id  =$request->national_id;
            $agent->save();
            toastr()->success(trans('تم اضافة المندوب بنجاح'));
            return redirect()->route('agents.index');

        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function edit($id){

        $agent = Agent::findorfail($id);
        return view('pages.Agents.edit',compact('agent'));

    }

    public function update(array $data, Agent $agent)
    {
        // Validate incoming data
        // Validate incoming data
        $validatedData = validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
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
        $agent->update($validatedData);

        return $agent;
    }

    public function destroy($request)
    {
        try {
            Agent::destroy($request->id);
            toastr()->error('تم حذف المندوب بنجاح');
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function storeTripRequest(Request $request)
    {
        try {
            $request->validate([
                'trip_id' => 'required|exists:trips,id',
                'total_people' => 'required|integer|min:1',
                'male_count' => 'required|integer|min:0',
                'female_count' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
            ]);

            $agent = Auth::guard('agent')->user();

            if (!$agent) {
                toastr()->error('حدث خطأ! تأكد من تسجيل الدخول.');
                return redirect()->back();
            }
            // جلب بيانات الرحلة

            // إنشاء الطلب في جدول `trip_requests`
            $tripRequest = TripRequest::create([
                'trip_id' => $request->trip_id,
                'agent_id' => $agent->id,
                'status' => 'pending',
            ]);

            // حفظ الصورة
//            $imagePath = $request->file('image')->store('trip_requests', 'public');

            // إنشاء التفاصيل في جدول `trip_request_details`
            TripRequestDetail::create([
                'trip_request_id' => $tripRequest->id,
                'total_people' => $request->total_people,
                'male_count' => $request->male_count,
                'female_count' => $request->female_count,
                'price' => $request->price,
            ]);
            $trip = Trip::findOrFail($request->trip_id);
            $admins = Admin::all(); // جلب جميع المدراء
            $providers = Provider::all(); // جلب جميع المزودين

            foreach ($admins as $admin) {
                $admin->notify(new TripRequested($trip));
            }

            foreach ($providers as $provider) {
                $provider->notify(new TripRequested($trip));
            }
            toastr()->success('تم إرسال الطلب بنجاح!');
            return redirect()->route('agent.requests'); // توجيه المستخدم إلى قائمة الحجوزات
        }
        catch (\Exception $e) {
            Log::error('Error storing trip request: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function myRequests()
    {
        $agentId = Auth::guard('agent')->user()->id;
        $requests = TripRequest::where('agent_id', $agentId)
            ->where('status', 'pending')
            ->with(['trip', 'agent', 'detail']) // إضافة التفاصيل
            ->get();

        return view('Pages.Agents.requests', compact('requests'));
    }
    public function confirmedTrips()
    {
        $agent = auth('agent')->user();
        $trips = TripRequest::where('agent_id', $agent->id)->where('status', 'confirmed')->with('trip')->get();
        return view('Pages.Agents.confirmed_trips', compact('trips'));
    }

    public function rejectedTrips()
    {
        $agent = auth('agent')->user();
        $trips = TripRequest::where('agent_id', $agent->id)->where('status', 'canceled')->with('trip')->get();
        return view('Pages.Agents.rejected_trips', compact('trips'));
    }

    public function requestTrip($trip_id)
    {
        try {
            $trip = Trip::findOrFail($trip_id);
            $agent = Auth::guard('agent')->user();

            if (!$agent) {
                toastr()->error('حدث خطأ! تأكد من تسجيل الدخول.');
                return redirect()->back();
            }

//            // التحقق إذا كان المندوب طلب الرحلة من قبل
//            $existingRequest = TripRequest::where('trip_id', $trip->id)
//                ->where('agent_id', $agent->id)
//                ->first();
//
//            if ($existingRequest) {
//                toastr()->info('لقد قمت بالفعل بطلب هذه الرحلة.');
//                return redirect()->back();
//            }
            // توجيه المندوب إلى صفحة إدخال التفاصيل
            return view('Pages.Agents.trip_request_form', compact('trip'));
        }
        catch (\Exception $e) {
            Log::error('Error requesting trip: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function dashboard()
    {
        $agentId = Auth::guard('agent')->user()->id; // جلب المعرّف الخاص بالمندوب المسجل

        // عدد الرحلات المطلوبة (pending)
        $requestedTrips = TripRequest::where('agent_id', $agentId)
            ->where('status', 'pending')
            ->count();

        // عدد الرحلات المقبولة (confirmed)
        $acceptedTrips = TripRequest::where('agent_id', $agentId)
            ->where('status', 'confirmed')
            ->count();

        // عدد الرحلات المرفوضة (canceled)
        $rejectedTrips = TripRequest::where('agent_id', $agentId)
            ->where('status', 'canceled')
            ->count();
        $allTrips = Trip::count();

        return view('Dashboard.agent.index', compact('requestedTrips', 'acceptedTrips', 'rejectedTrips','allTrips'));
    }

    public function showProfile($id)
    {
        $agent = Agent::findOrFail($id);

        // جلب جميع الرحلات التي طلبها المندوب
        $tripRequests = TripRequest::where('agent_id', $id)
            ->with(['trip', 'detail'])
            ->get();

        return view('pages.Agents.profile', compact('agent', 'tripRequests'));
    }

}



