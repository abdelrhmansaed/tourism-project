@extends('Dashboard.layouts.master')

@section('css')
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الرحلات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"><h4 class="content-title mb-0 my-auto">تعديل</h4></span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">



                    <form method="post" action="{{route('trips.update', $trip->id)}}" autocomplete="off">
                        @method('PUT')
                        @csrf

                        <div class="form-group col">
                            <label for="name">الاسم</label>
                            <input type="text"  value="{{$trip->name}}" name="name" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="type">النوغ</label>
                            <input type="text" value="{{$trip->type}}" name="type" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label for="date">اختر التاريخ:</label>
                            <input type="date" id="date" name="date" required  value="{{$trip->date}}"   >
                            <button type="submit">حفظ</button>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">{{ $trip->description }}</textarea>
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
