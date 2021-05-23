@extends('index');
@section('title','Trang chủ')
@section('content')
    <div class="container">
        <h1>Lấy lại mật khẩu bằng Email</h1>
        @if(session('send_forgot_pwd'))
            <div class="alert alert-success">{{ session('send_forgot_pwd') }}</div>
        @endif
        <form method="post" action="{{ url('/forgot-password') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email','') }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @if(session('exist_email'))
                    <div class="alert alert-danger">{{ session('exist_email') }}</div>
                @endif
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ url('/login') }}">Quay trở về trang đăng nhập</a>
        </form>
    </div>
@endsection
