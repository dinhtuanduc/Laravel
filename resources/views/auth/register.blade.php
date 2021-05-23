@extends('index');
@section('title','Trang chủ')
@section('content')
    <div class="container">
        <h1>Trang đăng kí tài khoản</h1>
        @if(session('register_success'))
            <div class="alert alert-success">{{ session('register_success') }}</div>
        @endif
        @if(session('register_failse'))
            <div class="alert alert-danger">{{ session('register_failse') }}</div>
        @endif
        <form method="post" action="{{ url('/register') }}">
            @csrf
            <div class="form-group">
                <label for="email">Name:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', '') }}">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email', '') }}">
                {{--            <div class="alert alert-danger" id="check-email"></div>--}}
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
            <div class="form-group">
                <label for="pwd_confirm">Password confirm:</label>
                <input type="password" class="form-control" name="pwd_confirm" id="pwd_confirm">
                @error('pwd_confirm')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" id="register" class="btn btn-primary">Submit</button>
        </form>
        <a href="{{ url('/login') }}">Đăng nhập</a>
    </div>
@endsection

