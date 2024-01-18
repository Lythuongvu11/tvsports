@extends('client.layouts.app')
@section('title', 'Đặt lại mật khẩu -')
@section('content')
<div class="container-fluid pt-5">
    <h2 class="text-center mb-5">Đặt lại mật khẩu</h2>
    @if(session('message'))
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    @endif
    <div class="row px-xl-12 justify-content-center">
        <form method="POST" action="{{ route('user.updatePassword') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="user" value="{{ $user->id }}">
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                @error('password_confirmation')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Xác nhận</button>
        </form>
    </div>
</div>
@endsection
