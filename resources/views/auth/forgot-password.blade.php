@extends('auth.layout')

@section('main_content')
  <h4 class="mb-2">Forgot Password? 🔒</h4>
  <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
  <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
    @csrf
    @if (Session::has('status'))
      <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif
    <div class="mb-3">
      <label for="email" class="form-label">{{ __('Email') }}</label>
      <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
        placeholder="Enter your email" required autofocus />
      @error('email')
        <div class="form-text text-danger">
          {{ $message }}
        </div>
      @enderror
    </div>
    <button class="btn btn-primary d-grid w-100">{{ __('Email Password Reset Link') }}</button>
  </form>
  <div class="text-center">
    <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
      <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
      Back to login
    </a>
  </div>
@endsection
