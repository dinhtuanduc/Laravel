@extends('index');
@section('title','Trang chủ')
@section('content')
    <div class="container">
        @if($active_status == null || $active_status == 0)
            <div>Tài khoản chưa xác thực. Bạn hãy vào email để xác thwucj tài khoản nhé!</div>
        @endif

            @if(session('email_verified_success'))
                <div class="alert alert-success">{{ session('email_verified_success') }}</div>
            @endif

            @if(session('email_verified_failse'))
                <div class="alert alert-danger">{{ session('email_verified_failse') }}</div>
            @endif
        <h1>Đăng nhập thành công</h1>
        <a href="{{ url('/logout') }}">Đăng xuất</a>
    </div>
@endsection
