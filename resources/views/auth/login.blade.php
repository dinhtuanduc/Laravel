@extends('index');
@section('title','Trang chủ')
@section('content')
    <div class="container">
        <h1>Màn hình đăng nhập</h1>
        @if(session('failse_login'))
            <div class="alert alert-danger">{{ session('failse_login') }}</div>
        @endif
        <form method="post" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="pwd" id="pwd">
                @error('pwd')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" value="1"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <a href="{{ url('/forgot-password') }}" style="margin-right: 50px">Quên mật khẩu</a>
        <a href="{{ url('/register') }}">Đăng kí</a>
    </div>
@endsection

