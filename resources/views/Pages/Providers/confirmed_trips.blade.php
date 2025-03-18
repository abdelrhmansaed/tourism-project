
@extends('Dashboard.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرحلات الموكدة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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
                                            <th>تفاصيل الطلب</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($trips as $trip)
                                            <tr>
                                                <td>{{ $trip->trip->name }}</td>
                                                <td>{{ $trip->agent->name }}</td>
                                                <td>
                                                    <a href="{{ route('trips.details', $trip->id) }}" class="btn btn-primary">
                                                        تفاصيل الرحلة
                                                    </a>                                                </td>
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

