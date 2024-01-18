@extends('client.layouts.app')
@section('title', 'Quên mật khẩu -')
@section('content')
    <div class="container-fluid pt-5">
        <h2 class="text-center mb-5">Quên mật khẩu</h2>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row px-xl-12 justify-content-center">
            <form method="POST" role="form">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" required>
                </div>
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary">Gửi email xác nhận</button>
            </form>
        </div>
    </div>
@endsection
