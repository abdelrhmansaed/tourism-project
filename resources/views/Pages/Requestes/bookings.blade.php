@extends('Dashboard.layouts.master')


@section('content')
    <div class="container">
        <h2>الحجوزات</h2>
        <table class="table">
            <thead>
            <tr>
                <th>الرحلة</th>
                <th>عدد الأشخاص</th>
                <th>عدد الذكور</th>
                <th>عدد الإناث</th>
                <th>السعر</th>
                <th>الصورة</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tripRequests as $request)
                <tr>
                    <td>{{ $request->trip->name }}</td>
                    <td>{{ $request->detail->total_people }}</td>
                    <td>{{ $request->detail->male_count }}</td>
                    <td>{{ $request->detail->female_count }}</td>
                    <td>{{ $request->detail->price }} ريال</td>
                    <td>
                        @if($request->detail->image)
                            <img src="{{ asset('storage/' . $request->detail->image) }}" alt="صورة الطلب" width="100">
                        @else
                            <span>لا توجد صورة</span>
                        @endif
                    </td>
                    <td>{{ $request->status }}</td>
                    <td>
                        <form method="POST" action="{{ route('agent.confirmTrip', $request->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success" type="submit">تأكيد الحجز</button>
                        </form>

                        <form method="POST" action="{{ route('agent.cancelTrip', $request->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger" type="submit">إلغاء الحجز</button>
                        </form>
                    </td>
                </tr>            @endforeach
            </tbody>
        </table>
    </div>
@endsection


