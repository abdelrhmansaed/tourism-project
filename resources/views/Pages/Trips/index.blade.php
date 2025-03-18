@extends('Dashboard.layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endsection



@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">قائمة الرحلات</h3>
            </div>
            <div class="card-body">
                <a href="{{route('trips.create')}}" class="btn btn-success mb-3">➕ إضافة رحلة</a>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>📌 الاسم</th>
                            <th>🛶 النوع</th>
                            <th>📅 التاريخ</th>
                            <th>📖 الوصف</th>
                            <th>⚙️ العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trips as $trip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$trip->name}}</td>
                                <td>{{$trip->type}}</td>
                                <td>{{$trip->date}}</td>
                                <td>{{$trip->description}}</td>
                                <td>
                                    <a href="{{route('trips.edit', $trip->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_trip{{ $trip->id }}"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-primary btn-sm request-trip-btn" data-trip-id="{{ $trip->id }}">📝 طلب الرحلة</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة طلب الرحلة (Modal) -->
    <div class="modal fade" id="tripRequestModal" tabindex="-1" aria-labelledby="tripRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tripRequestModalLabel">طلب رحلة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tripRequestForm" action="{{ route('agent.storeTripRequest')}}" method="POST">
                        @csrf
                        <input type="hidden" name="trip_id" id="trip_id">
                        <div class="mb-3">
                            <label class="form-label">👥 عدد الأفراد</label>
                            <input type="number" name="total_people" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">👨 عدد الذكور</label>
                                <input type="number" name="male_count" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">👩 عدد الإناث</label>
                                <input type="number" name="female_count" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">💰 السعر</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2">🚀 إرسال الطلب</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".request-trip-btn").click(function() {
                var tripId = $(this).data("trip-id");
                $("#trip_id").val(tripId);
                $("#tripRequestModal").modal("show");
            });


        });
    </script>
@endsection
