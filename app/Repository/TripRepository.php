<?php

namespace App\Repository;

use App\Models\Agent;
use App\Models\Provider;
use App\Models\Trip;
use App\Notifications\TripAccepted;
use App\Notifications\TripRequested;
use App\Repository\TripRepositoryInterface;
use Illuminate\Http\Request;

class TripRepository implements TripRepositoryInterface
{

    public function index()
    {

        $trips = Trip::all();
        return view('Pages.Trips.index',compact('trips')) ;
    }

    public function create()
    {
        return view('Pages.Trips.add') ;
    }

    public function store(Request $request)
    {
        try {

            $trip = new Trip();
            $trip ->name  =$request->name;
            $trip ->type  =$request->type;
            $trip->date = $request->date;
            $trip->description = $request->description;
            $trip->save();
            toastr()->success(trans('تم اضافة الرحلة بنجاح'));
           return redirect()->route('trips.index');

        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $trip = Trip::findorfail($id);
        return view('pages.Trips.edit',compact('trip'));
    }

    public function update(Request $request, $id)
    {
        try {
            // البحث عن الرحلة المطلوبة
            $trip = Trip::findOrFail($id);

            // تحديث البيانات
            $trip->name = $request->name;
            $trip->type = $request->type;
            $trip->date = $request->date;
            $trip->description = $request->description;
            $trip->save();

            toastr()->success(trans('تم تحديث الرحلة بنجاح'));
            return redirect()->route('trips.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Provider::destroy($request->id);
            toastr()->error('تم حذف الرحلة بنجاح');
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }




}
