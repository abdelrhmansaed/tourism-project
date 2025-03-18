{{--@extends('Dashboard.layouts.master')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h2>طلب رحلة: {{ $trip->name }}</h2>--}}
{{--        <p><strong>تاريخ الرحلة:</strong> {{ $trip->date }}</p>--}}
{{--        <p><strong>الوصف:</strong> {{ $trip->description }}</p>--}}

{{--        <form method="POST" action="{{ route('agent.storeTripRequest') }}" enctype="multipart/form-data">--}}
{{--            @csrf--}}

{{--            <input type="hidden" name="trip_id" value="{{ $trip->id }}">--}}

{{--            <div class="mb-3">--}}
{{--                <label>عدد الأفراد</label>--}}
{{--                <input type="number" name="total_people" class="form-control" required oninput="updateGenderCounts()">--}}
{{--            </div>--}}

{{--            <div class="mb-3">--}}
{{--                <label>عدد الذكور</label>--}}
{{--                <input type="number" name="male_count" class="form-control" required>--}}
{{--            </div>--}}

{{--            <div class="mb-3">--}}
{{--                <label>عدد الإناث</label>--}}
{{--                <input type="number" name="female_count" class="form-control" required>--}}
{{--            </div>--}}

{{--            <div class="mb-3">--}}
{{--                <label>السعر</label>--}}
{{--                <input type="number" name="price" class="form-control" required>--}}
{{--            </div>--}}



{{--            <button type="submit" class="btn btn-primary">إرسال الطلب</button>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        function updateGenderCounts() {--}}
{{--            let totalPeople = document.querySelector('input[name="total_people"]').value;--}}
{{--            let maleInput = document.querySelector('input[name="male_count"]');--}}
{{--            let femaleInput = document.querySelector('input[name="female_count"]');--}}

{{--            maleInput.max = totalPeople;--}}
{{--            femaleInput.max = totalPeople;--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
