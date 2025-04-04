
@extends('Dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{trans('dashboard/main_trans.agents')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>


@endsection
@section('content')


    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50" style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>اسم الرحلة</th>
                                            <th>المندوب</th>
                                            <th>عدد الاشخاص</th>
                                            <th>عدد الذكور</th>
                                            <th>عدد الاناث</th>
                                            <th>السعر</th>
                                            <th>حالة الرحلة</th>
                                            <th>ايصال الدفع</th>
                                            <th>الاجرات</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($requests as $request)
                                            <tr>
                                                <td>{{ $request->trip->name }}</td>
                                                <td>{{ $request->agent->name }}</td>
                                                <td>{{ optional($request->detail)->total_people }}</td>
                                                <td>{{ optional($request->detail)->male_count }}</td>
                                                <td>{{ optional($request->detail)->female_count }}</td>
                                                <td>{{ optional($request->detail)->price }}</td>


                                                <td>
                                                    <span class="badge bg-warning">قيد الانتظار</span>
                                                </td>

                                                <td>
                                                    @if(optional($request->detail)->image)
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $request->id }}">
                                                            إيصال الدفع
                                                        </button>

                                                        <!-- نافذة منبثقة لعرض الصورة -->
                                                        <div class="modal fade" id="paymentModal-{{ $request->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">إيصال الدفع</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ Storage::url($request->detail->image) }}" class="img-fluid" alt="إيصال الدفع">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-danger">لم يتم رفع إيصال</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <form action="{{ route('provider.approveRequest', $request->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success">قبول الطلب</button>
                                                    </form>
                                                    <form action="{{ route('provider.rejectRequest', $request->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-danger">رفض الطلب</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection

