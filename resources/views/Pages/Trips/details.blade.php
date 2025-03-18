@extends('Dashboard.layouts.master')

@section('content')
    <div class="container">
        <h2>تفاصيل الرحلة</h2>
        <p><strong>اسم الرحلة:</strong> {{ $trip->trip->name }}</p>
        <p><strong>المندوب:</strong> {{ $trip->agent->name }}</p>
        <p><strong>عدد الأشخاص:</strong> {{ optional($trip->detail)->total_people }}</p>
        <p><strong>عدد الذكور:</strong> {{ optional($trip->detail)->male_count }}</p>
        <p><strong>عدد الإناث:</strong> {{ optional($trip->detail)->female_count }}</p>
        <p><strong>السعر:</strong> {{ optional($trip->detail)->price }} جنيه</p>

        <!-- عرض حالة الرحلة -->
        <p><strong>حالة الرحلة:</strong>
            @if($trip->status == 'pending')
                <span class="badge bg-warning">قيد الانتظار</span>
            @elseif($trip->status == 'waiting_payment')
                <span class="badge bg-info">في انتظار الدفع</span>
            @elseif($trip->status == 'waiting_confirmation')
                <span class="badge bg-primary">في انتظار التأكيد</span>
            @elseif($trip->status == 'confirmed')
                <span class="badge bg-success">مؤكدة</span>
            @elseif($trip->status == 'canceled')
                <span class="badge bg-danger">ملغاة</span>
            @endif
        </p>

        <!-- عرض إيصال الدفع إذا وُجد -->
        <p><strong>إيصال الدفع:</strong></p>
        @if(optional($trip->detail)->image)
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#paymentModal">
                عرض الإيصال
            </button>

            <!-- نافذة منبثقة لعرض الصورة -->
            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">إيصال الدفع</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ Storage::url($trip->detail->image) }}" class="img-fluid" alt="إيصال الدفع">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <span class="text-danger">لم يتم رفع إيصال الدفع</span>
        @endif
    </div>
    <a href="{{ route('trips.downloadPDF', $trip->id) }}" class="btn btn-danger">
        تنزيل التفاصيل PDF
    </a>

@endsection
