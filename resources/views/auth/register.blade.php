@extends('Dashboard.layouts.master2')

@section('css')
    <!-- Sidemenu-responsive-tabs css -->
    <link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- القسم الخاص بالصورة -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>

            <!-- قسم التسجيل -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="sign-favicon ht-40" alt="logo">
                                        </a>
                                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Va<span>le</span>x</h1>
                                    </div>

                                    <div class="main-signup-header">
                                        <h2 class="text-primary">إنشاء حساب جديد</h2>
                                        <h5 class="font-weight-normal mb-4">التسجيل مجاني ويستغرق دقيقة واحدة فقط.</h5>

                                        <!-- نموذج التسجيل -->
                                        <form method="POST" action="{{ route('auth.register') }}">
                                            @csrf

                                            <div class="form-group">
                                                <label>الاسم بالكامل</label>
                                                <input class="form-control" name="name" placeholder="أدخل اسمك" type="text" required>
                                            </div>

                                            <div class="form-group">
                                                <label>البريد الإلكتروني</label>
                                                <input class="form-control" name="email" placeholder="أدخل بريدك الإلكتروني" type="email" required>
                                            </div>

                                            <div class="form-group">
                                                <label>كلمة المرور</label>
                                                <input class="form-control" name="password" placeholder="أدخل كلمة المرور" type="password" required>
                                            </div>

                                            <div class="form-group">
                                                <label>اختر نوع الحساب</label>
                                                <select class="form-control" name="user_type" required>
                                                    <option value="agent">Agent</option>
                                                    <option value="provider">Provider</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>

                                            <button class="btn btn-main-primary btn-block" type="submit">تسجيل</button>
                                        </form>

                                        <!-- روابط تسجيل الدخول واستعادة كلمة المرور -->
                                        <div class="main-signin-footer mt-5">
                                            <p><a href="#">هل نسيت كلمة المرور؟</a></p>
                                            <p>لديك حساب بالفعل؟ <a href="{{ route('auth.login') }}">تسجيل الدخول</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- نهاية التسجيل -->
                </div>
            </div> <!-- نهاية القسم -->
        </div>
    </div>
@endsection

@section('js')
@endsection
