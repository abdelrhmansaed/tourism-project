@extends('Dashboard.layouts.master')

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{trans('dashboard/main_trans.providers')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{route('providers.store')}}" autocomplete="off">
                        @csrf

                        <div class="form-group col">
                            <label for="name">الاسم</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="email">الايميل</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="password">كلمة السر</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="age">السن</label>
                            <input type="number" name="age" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="id_number">رقم الهوية</label>
                            <input type="text" name="national_id" class="form-control">
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">تأكيد</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
