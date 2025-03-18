@extends('Dashboard.layouts.master')

@section('content')
    <div class="container">
        <h2>الرحلات التي وافق عليها البروفايدر</h2>
        <table class="table">
            <thead>
            <tr>

                <th>الرحلة</th>
                <th>عدد الأشخاص</th>
                <th>المندوب</th>
                <th>عدد الذكور</th>
                <th>عدد الإناث</th>
                <th>السعر</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trips as $trip)
                <tr>
                    <td>{{ $trip->trip->name }}</td>
                    <td>{{ $trip->agent->name }}</td>
                    <td>{{ optional($trip->detail)->total_people }}</td>
                    <td>{{ optional($trip->detail)->male_count }}</td>
                    <td>{{ optional($trip->detail)->female_count }}</td>
                    <td>{{ optional($trip->detail)->price }}</td>
                    <td>
                        <form id="payment-form-{{ $trip->id }}" action="{{ route('trips.uploadPayment', $trip->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="payment_proof" id="file-input-{{ $trip->id }}" style="display: none;" accept="image/*">

                            <!-- زر اختيار الصورة -->
                            <button type="button" class="btn btn-success" onclick="document.getElementById('file-input-{{ $trip->id }}').click();">
                                رفع إثبات الدفع
                            </button>

                            <!-- زر تأكيد الطلب -->
                            <button type="submit" class="btn btn-primary" style="margin-left: 10px;" id="confirm-btn-{{ $trip->id }}" disabled>
                                تأكيد الطلب
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

<script>
    document.querySelectorAll('input[type=file]').forEach(input => {
        input.addEventListener('change', function() {
            let tripId = this.id.replace('file-input-', '');
            let confirmButton = document.getElementById('confirm-btn-' + tripId);

            if (this.files.length > 0) {
                confirmButton.removeAttribute('disabled'); // تفعيل زر التأكيد بعد اختيار الصورة
            } else {
                confirmButton.setAttribute('disabled', 'true'); // تعطيل زر التأكيد إذا لم يتم اختيار صورة
            }
        });
    });
</script>

@endsection
