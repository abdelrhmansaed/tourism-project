
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
    <!-- breadcrumb -->

@endsection
@section('content')
    <!-- row -->

        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <div class="col-xl-12 mb-30">
                            <div class="card card-statistics h-100">
                                <div class="card-body">
                                    <a href="{{route('agents.create')}}" class="btn btn-success btn-sm" role="button"
                                       aria-pressed="true">اضافة مندوب</a><br><br>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                               data-page-length="50"
                                               style="text-align: center">
                                            <thead>
                                            <tr class="alert-success">
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>السن</th>
                                                <th>الايميل</th>
                                                <th>رقم الهوية</th>
                                                <th>العمليات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                       @foreach($agents as $agent)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$agent->name}}</td>
                                                    <td>{{$agent->age}}</td>
                                                    <td>{{$agent->email}}</td>
                                                    <td>{{$agent->national_id}}</td>
                                                    <td>
                                                        <a href="{{route('agents.edit',$agent->id)}}"class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_agent{{ $agent->id }}" title="حذف"><i class="fa fa-trash"></i></button>
                                                        <a href="{{ route('agents.profile', $agent->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </td>
                                                <tr>
                                            @include('pages.Agents.delete')
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
