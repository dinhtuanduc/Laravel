@extends('index')
@section('content')
    <div class="container">
        <h1>Tạo mới khẩu khẩu</h1>
        @if(session('reset_pwd_success'))
            <div class="alert alert-success">{{ session('reset_pwd_success') }}</div>
        @endif
        @if(session('reset_pwd_failse'))
            <div class="alert alert-danger">{{ session('reset_pwd_failse') }}</div>
        @endif
        <form method="post" action="{{ url('/reset-password/') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
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
