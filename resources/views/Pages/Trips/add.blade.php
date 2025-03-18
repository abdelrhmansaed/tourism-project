@extends('Dashboard.layouts.master')

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">اضافة رحلة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
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

                    <form method="post" action="{{route('trips.store')}}" autocomplete="off">
                        @csrf

                        <div class="form-group col">
                            <label for="name">الاسم</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="type">النوغ</label>
                            <input type="text" name="type" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="date">اختر التاريخ:</label>
                            <input type="date" id="date" name="date" required>
                            <button type="submit">حفظ</button>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">الوصف</label>
                            <textarea class="form-control" name="description"  id="exampleFormControlTextarea1" rows="3"></textarea>
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
